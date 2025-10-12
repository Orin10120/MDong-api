<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lecturer;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = Lecturer::with(['topics', 'periods', 'applicationHistories'])->get();
        return response()->json($lecturers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:lecturers',
            'nip' => 'required|unique:lecturers',
            'username' => 'required|unique:lecturers',
            'email' => 'required|email|unique:lecturers',
            'password' => 'required|min:6',
            'study_program' => 'required',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $lecturer = Lecturer::create($validated);

        return response()->json([
            'message' => 'Lecturer created successfully',
            'data' => $lecturer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lecturer = Lecturer::with(['topics', 'periods', 'applicationHistories'])->find($id);

         if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $lecturer->topics = $lecturer->topics ?? [];
        $lecturer->periods = $lecturer->periods ?? [];
        $lecturer->applicationHistories = $lecturer->applicationHistories ?? [];

        return response()->json($lecturer, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $lecturer->update($request->all());
        return response()->json([
            'message' => 'Lecturer updated successfully',
            'data' => $lecturer
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lecturer = Lecturer::find($id);
        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        $lecturer->delete();
        return response()->json(['message' => 'Lecturer deleted successfully'], 200);
    }

    public function histories(string $id)
    {
        $lecturer = Lecturer::with('applicationHistories')->find($id);

        if (!$lecturer) {
            return response()->json(['message' => 'Lecturer not found'], 404);
        }

        return response()->json([
            'lecturer' => $lecturer->name,
            'histories' => $lecturer->applicationHistories,
        ], 200);
    }

    public function attachHistory(Request $request, string $id)
    {
        $validated = $request->validate([
            'history_id' => 'required|exists:application_histories,id',
        ]);

        $lecturer = Lecturer::findOrFail($id);
        $lecturer->applicationHistories()->attach($validated['history_id']);

        return response()->json(['message' => 'History successfully attached to lecturer'], 201);
    }

    public function detachHistory(Request $request, string $id)
    {
        $validated = $request->validate([
            'history_id' => 'required|exists:application_histories,id',
        ]);

        $lecturer = Lecturer::findOrFail($id);
        $lecturer->applicationHistories()->detach($validated['history_id']);

        return response()->json(['message' => 'History successfully detached from lecturer'], 200);
    }
}
