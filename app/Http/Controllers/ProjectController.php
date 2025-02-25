<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function show($id)
    {
        $project = Project::with('users', 'timesheets')->findOrFail($id);
        return response()->json($project);
    }
    // Fetch all projects with optional filtering
    public function index(Request $request)
    {
        $query = Project::with('users', 'timesheets');

    // Filter by specific user if 'user_id' is provided in the request
    if ($userId = $request->input('user_id')) {
        $query->whereHas('users', fn($q) => $q->where('user_id', $userId));
    }
        // Standard attribute filtering
        if ($filters = $request->input('filters')) {
            foreach ($filters as $field => $value) {
                if (in_array($field, ['name', 'status'])) {
                    $query->where($field, 'LIKE', "%$value%");
                }
            }
        }

        // EAV attribute filtering
        if (!empty($filters)) {
            foreach ($filters as $attrName => $value) {
                if (!in_array($attrName, ['name', 'status'])) {
                    $query->whereHas('attributes', function ($q) use ($attrName, $value) {
                        $q->where('name', $attrName)
                          ->whereHas('values', fn($q) => $q->where('value', 'LIKE', "%$value%"));
                    });
                }
            }
        }
        // $projects = $query->get();
        return response()->json($query->get());
    }

    // Store a new project with dynamic attributes
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|string',
            'attributes' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $project = Project::create($request->only('name', 'status'));

        // Handle EAV attributes
        if ($attributes = $request->input('attributes')) {
            foreach ($attributes as $name => $value) {
                $attribute = Attribute::firstOrCreate(['name' => $name]);
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $project->id,
                    'value' => $value,
                ]);
            }
        }

        return response()->json($project, 201);
    }
}