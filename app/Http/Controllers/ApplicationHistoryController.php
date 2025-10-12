<?php

namespace App\Http\Controllers;

use App\Models\ApplicationHistory;
use App\ResponseFormatter;
use Illuminate\Http\Request;

class ApplicationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $application_histories = ApplicationHistory::with('lecturers')->get();

        $data = $application_histories->map(function ($history) {
            $response = $history->api_response;
            $response['lecturers'] = $history->lecturers;
            return $response;
        });

        return ResponseFormatter::success($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'student_id' => 'required|exists:students,id',
            'is_pembimbing' => 'required|string|in:PBB-1,PBB-2',
            'submission_date' => 'required|date',
            'response_date' => 'nullable|date',
            'response' => 'required|string|in:PENDING,ACCEPTED,REJECTED',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $data = [
            'student_id' => $request->student_id,
            'is_pembimbing' => $request->is_pembimbing,
            'submission_date' => $request->submission_date,
            'response_date' => $request->response_date,
            'response' => $request->response,
        ];

        $application_history = ApplicationHistory::create($data);
        return $this->show($application_history->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application_history = ApplicationHistory::with('lecturers')->findOrFail($id);

        $response = $application_history->api_response;
        $response['lecturers'] = $application_history->lecturers;

        return ResponseFormatter::success($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application_history = ApplicationHistory::findOrFail($id);

        $validator = validator($request->all(), [
            'student_id' => 'sometimes|exists:students,id',
            'is_pembimbing' => 'sometimes|string|in:PBB-1,PBB-2',
            'submission_date' => 'sometimes|date',
            'response_date' => 'nullable|date',
            'response' => 'sometimes|string|in:PENDING,ACCEPTED,REJECTED',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $data = [
            'student_id' => $request->student_id,
            'is_pembimbing' => $request->is_pembimbing,
            'submission_date' => $request->submission_date,
            'response_date' => $request->response_date,
            'response' => $request->response,
        ];


        $application_history->update($data);
        return $this->show($application_history->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application_history = ApplicationHistory::findOrFail($id);
        $application_history->delete();
        return ResponseFormatter::success(null, 'Application history deleted');
    }

    public function lecturers(string $id)
    {
        $application_history = ApplicationHistory::with('lecturers')->findOrFail($id);

        return ResponseFormatter::success($application_history->lecturers);
    }

     public function attachLecturer(Request $request, string $id)
    {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $application_history = ApplicationHistory::findOrFail($id);
        $application_history->lecturers()->attach($validated['lecturer_id']);

        return ResponseFormatter::success(null, 'Lecturer successfully attached to ApplicationHistory');
    }

    public function detachLecturer(Request $request, string $id)
    {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        $application_history = ApplicationHistory::findOrFail($id);
        $application_history->lecturers()->detach($validated['lecturer_id']);

        return ResponseFormatter::success(null, 'Lecturer successfully detached from ApplicationHistory');
    }
}
