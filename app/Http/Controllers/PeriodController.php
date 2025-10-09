<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $period = Period::create($validated);
        return response()->json(['message' => 'Period created', 'data' => $period], 201);
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
        $period = Period::find($id);
        if (!$period) {
            return response()->json(['message' => 'Period not found'], 404);
        }

        $period->update($request->all());
        return response()->json(['message' => 'Period updated', 'data' => $period], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $period = Period::find($id);
        if (!$period) {
            return response()->json(['message' => 'Period not found'], 404);
        }

        $period->delete();
        return response()->json(['message' => 'Period deleted'], 200);
    }
}
