<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function store(Request $request)
    {
        $attributeValue = AttributeValue::create($request->all());
        return response()->json($attributeValue, 201);
    }

    public function update(Request $request, AttributeValue $attributeValue)
    {
        $attributeValue->update($request->all());
        return response()->json($attributeValue);
    }

    public function destroy(AttributeValue $attributeValue)
    {
        $attributeValue->delete();
        return response()->json(['message' => 'Attribute Value deleted']);
    }
}
