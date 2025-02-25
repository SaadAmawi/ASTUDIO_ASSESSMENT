<?php

namespace App\Http\Controllers;
use App\Models\Attribute;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeController extends Controller
{

    public function index(){
        $attributes = Attribute::all();
        if(!$attributes){
            return response()->json('No Attributes Available',404);
        }
        return response()->json($attributes,201);

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:text,date,number,select',
        ]);

        $attribute = Attribute::create($request->all());

        return response()->json($attribute, 201);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);

        if (!$attribute) {
            return response()->json(['message' => 'Attribute not found'], 404);
        }

        $attribute->update($request->all());

        return response()->json($attribute);
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return response()->json(['message' => 'Attribute deleted']);
    }
}
