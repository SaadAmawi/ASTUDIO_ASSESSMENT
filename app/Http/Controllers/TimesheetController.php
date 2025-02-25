<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Timesheet;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
  

    // Fetch all timesheets
    public function index()
    {
        return response()->json(Timesheet::with('user', 'project')->get());
    }

    // Store a new timesheet record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string',
            'date' => 'required|date',
            'hours' => 'required|numeric',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $timesheet = Timesheet::create($request->all());
        return response()->json($timesheet, 201);
    }
}
