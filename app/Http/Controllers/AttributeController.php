<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:text,date,number,select',
    ]);

    $attribute = Attribute::create($validatedData);
    return response()->json($attribute, 201);
}

public function update(Request $request, $id)
{
    $attribute = Attribute::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:text,date,number,select',
    ]);

    $attribute->update($request->all());
    return response()->json($attribute);
}

public function destroy($id)
{
    $attribute = Attribute::findOrFail($id);
    $attribute->delete();

    return response()->json(['message' => 'Attribute deleted successfully']);
}

public function show($id)
{
    $attribute = Attribute::findOrFail($id);
    return response()->json($attribute);
}

public function index()
{
    $attributes = Attribute::all();
    return response()->json($attributes);
}

}
