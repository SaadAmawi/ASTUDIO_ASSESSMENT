<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class ProjectAttributeController extends Controller
{
    public function setAttributes(Request $request, $id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }

        foreach ($request->all() as $key => $value) {
            $attribute = Attribute::where('name', $key)->first();

            if ($attribute) {
                AttributeValue::updateOrCreate(
                    ['attribute_id' => $attribute->id, 'entity_id' => $project->id, 'entity_type' => Project::class],
                    ['value' => $value]
                );
            }
        }

        return response()->json(['message' => 'Attributes set successfully']);
    }

    public function getAttributes($id)
{
    $project = Project::with('attributeValues.attribute')->find($id);

    if (!$project) {
        return response()->json(['message' => 'Project not found'], 404);
    }

    return response()->json($project->attributeValues);
}

}