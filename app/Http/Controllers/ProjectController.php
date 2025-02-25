<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProjectAttributeController;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();
        if ($filters = $request->input('filters')) {
            $this->filter($query, $filters);
        }
        $projects = $query->get();

        return response()->json($projects);
    }
    
    public function show($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($project::with('users')->find($id));
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project)
    {
        $project->update($request->all());
        return response()->json($project);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message' => 'Project deleted']);
    }

    private function filter($query, $filters)
{
    foreach ($filters as $key => $value) {
        // Determine the operator (default is '=')
        $operator = '=';
        if (strpos($value, ':') !== false) {
            list($value, $operator) = explode(':', $value);
        }

        // Handle regular column filtering (e.g., name, status)
        if (in_array($key, ['name', 'status'])) {
            if ($operator === 'LIKE') {
                $query->where($key, 'LIKE', "%$value%");
            } elseif ($operator === '>') {
                $query->where($key, '>', $value);
            } elseif ($operator === '<') {
                $query->where($key, '<', $value);
            } else {
                $query->where($key, '=', $value);
            }
        }

        // Handle EAV filtering for dynamic attributes using the attribute_values table
        elseif ($key && $value) {
            $query->whereHas('attributeValues', function ($query) use ($key, $value, $operator) {
                // Filter by attribute name and value
                $query->where('attribute_values.attribute_id', function ($query) use ($key) {
                    $query->select('id')->from('attributes')->where('name', $key);
                });

                // Apply the operator for value comparison
                if (is_numeric($value)) {
                    // If the value is numeric, cast it and apply comparison
                    if ($operator === '>') {
                        $query->where('value', '>', $value);
                    } elseif ($operator === '<') {
                        $query->where('value', '<', $value);
                    } else {
                        $query->where('value', '=', $value);
                    }
                } else {
                    // For non-numeric values (e.g., text), use LIKE for matching
                    if ($operator === 'LIKE') {
                        $query->where('value', 'LIKE', "%$value%");
                    } else {
                        $query->where('value', '=', $value);
                    }
                }
            });
        }
    }
}


public function updateAttributes(Request $request, $projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        foreach ($request->all() as $key => $value) {
            $attribute = Attribute::where('name', $key)->first();


            if (!$attribute) {
                return response()->json(['message' => "Attribute '$key' not found"], 400);
            }


            AttributeValue::updateOrCreate(
                [
                    'attribute_id' => $attribute->id,
                    'entity_id' => $projectId,
                    'entity_type' => Project::class, 
                ],
                [
                    'value' => $value
                ]
            );
        }

        return response()->json(['message' => 'Attributes updated successfully']);
    }

    public function assignUsers(Request $request, $projectId)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array', 
            'user_ids.*' => 'exists:users,id', 
        ]);

        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        $project->users()->sync($validated['user_ids']); 
        return response()->json(['message' => 'Users assigned to the project successfully']);
    }



}
