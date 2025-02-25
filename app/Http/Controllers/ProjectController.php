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
    public function index()
    {
        $projects = Project::all();
        if ($projects->isEmpty()) {
            return response()->json(['message' => 'No projects found.'], 404);
        }
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

//     public function filter(Request $request)
// {
//     $query = Project::query();

//     foreach ($request->filters as $attribute => $value) {
//         $attributeModel = Attribute::where('name', $attribute)->first();

//         if ($attributeModel) {
//             $query->whereHas('attributeValues', function ($query) use ($attributeModel, $value) {
//                 $query->where('attribute_id', $attributeModel->id)
//                       ->where('value', $value);
//             });
//         }
//     }

//     $projects = $query->get();

//     return response()->json($projects);
// }

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
