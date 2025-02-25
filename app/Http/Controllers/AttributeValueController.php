<?php

namespace App\Http\Controllers;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index(){
        $attributeValue = AttributeValue::all();
        if(!$attributeValue){
            return response()->json('No Attributes Available',404);
        }
        return response()->json($attributeValue,201);

    }
    public function show($id){
        $attributeValue = AttributeValue::find($id);
        if(!$attributeValue){
            return response()->json('No Attributes Available',404);
        }
        return response()->json($attributeValue,201);

    }
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
