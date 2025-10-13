<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Period;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = Period::with('lecturer')->get();
        return response()->json($periods, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lecturer = Auth::guard('dosen')->user();

        if (!$lecturer) {
            return response()->json(['message' => 'Unauthorized. Please log in as lecturer.'], 401);
        }

        if ($lecturer->is_admin !== 'YES') {
            return response()->json(['message' => 'Forbidden. Only admin lecturers can create periods.'], 403);
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $period = Period::create([
            'lecturer_id' => $lecturer->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return response()->json([
            'message' => 'Period created successfully',
            'data' => $period->load('lecturer')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $period = Period::with('lecturer')->find($id);
        if (!$period) {
            return response()->json(['message' => 'Period not found'], 404);
        }

        return response()->json($period, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lecturer = Auth::guard('dosen')->user();

        if (!$lecturer) {
            return response()->json(['message' => 'Unauthorized. Please log in as lecturer.'], 401);
        }

        if ($lecturer->is_admin !== 'YES') {
            return response()->json(['message' => 'Forbidden. Only admin lecturers can update periods.'], 403);
        }

        $period = Period::find($id);
        if (!$period) {
            return response()->json(['message' => 'Period not found'], 404);
        }

        $validated = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
        ]);

        $period->update($validated);

        return response()->json([
            'message' => 'Period updated successfully',
            'data' => $period->load('lecturer')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lecturer = Auth::guard('dosen')->user();

        if (!$lecturer) {
            return response()->json(['message' => 'Unauthorized. Please log in as lecturer.'], 401);
        }

        if ($lecturer->is_admin !== 'YES') {
            return response()->json(['message' => 'Forbidden. Only admin lecturers can delete periods.'], 403);
        }

        $period = Period::find($id);
        if (!$period) {
            return response()->json(['message' => 'Period not found'], 404);
        }

        $period->delete();

        return response()->json(['message' => 'Period deleted successfully'], 200);
    }
}
