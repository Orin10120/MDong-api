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
        $lecturers = Lecturer::with(['topic', 'periods', 'applicationHistories'])->get();
        return response()->json($lecturers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'code' => 'required|unique:lecturers',
                'nip' => 'required|unique:lecturers',
                'phone' => 'nullable|string|max:20',
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

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lecturer = Lecturer::with(['topic', 'periods', 'applicationHistories'])->find($id);

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
        try {
            $lecturer = Lecturer::find($id);
            if (!$lecturer) {
                return response()->json([
                    'message' => 'Lecturer not found'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'code' => 'sometimes|unique:lecturers,code,' . $id,
                'nip' => 'sometimes|unique:lecturers,nip,' . $id,
                'username' => 'sometimes|unique:lecturers,username,' . $id,
                'phone' => 'nullable|string|max:20',
                'email' => 'sometimes|email|unique:lecturers,email,' . $id,
                'password' => 'sometimes|min:6',
                'study_program' => 'sometimes|string|max:255',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            }

            $lecturer->update($validated);

            return response()->json([
                'message' => 'Lecturer updated successfully',
                'data' => $lecturer
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
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
