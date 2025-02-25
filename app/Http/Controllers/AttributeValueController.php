<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function store(Request $request, $projectId)
{
    $request->validate([
        'attribute_id' => 'required|exists:attributes,id',
        'value' => 'required|string',
    ]);

    $project = Project::findOrFail($projectId);

    $attributeValue = new AttributeValue([
        'attribute_id' => $request->attribute_id,
        'value' => $request->value,
    ]);

    $project->attributeValues()->save($attributeValue);
    return response()->json($attributeValue, 201);
}

public function update(Request $request, $projectId, $id)
{
    $request->validate([
        'value' => 'required|string',
    ]);

    $project = Project::findOrFail($projectId);
    $attributeValue = $project->attributeValues()->findOrFail($id);
    $attributeValue->update($request->only('value'));

    return response()->json($attributeValue);
}

public function destroy($projectId, $id)
{
    $project = Project::findOrFail($projectId);
    $attributeValue = $project->attributeValues()->findOrFail($id);
    $attributeValue->delete();

    return response()->json(['message' => 'Attribute Value deleted successfully']);
}

public function show($projectId, $id)
{
    $project = Project::findOrFail($projectId);
    $attributeValue = $project->attributeValues()->findOrFail($id);
    return response()->json($attributeValue);
}

public function index($projectId)
{
    $project = Project::findOrFail($projectId);
    return response()->json($project->attributeValues);
}

}
