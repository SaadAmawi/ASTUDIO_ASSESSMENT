<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{


    public function index(){
        $timesheet = Timesheet::all();
        return response()->json($timesheet);
    }
    public function show($id){
        $timesheet = Timesheet::find($id);

        if (!$id){
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($timesheet);
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
        ]);

        $user = User::find($validatedData['user_id']);
        $project = Project::find($validatedData['project_id']);

        if (!$user || !$project) {
            return response()->json(['message' => 'User or Project not found'], 404);
        }

        $timesheet = Timesheet::create([
            'task_name' => $validatedData['task_name'],
            'date' => $validatedData['date'],
            'hours' => $validatedData['hours'],
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);
        return response()->json([
            'message' => 'Timesheet created successfully',
            'timesheet' => $timesheet
        ], 201);
    }


    public function update(Request $request, Timesheet $timesheet)
    {
        $timesheet->update($request->all());
        return response()->json($timesheet);
    }

    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();
        return response()->json(['message' => 'Timesheet deleted']);
    }
}
