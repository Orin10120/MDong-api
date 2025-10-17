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
        $application_histories = ApplicationHistory::with(['lecturers.topic', 'student'])->get();

        $data = $application_histories->flatMap(function ($history) {
            return $history->lecturers->map(function ($lecturer) use ($history) {
                return [
                    'id' => $history->id,
                    'student_id' => $history->student->id,
                    'student_name' => $history->student->name,
                    'lecturer_id' => $lecturer->id,
                    'lecturer_name' => $lecturer->name,
                    'lecturer_code' => $lecturer->code,
                    'lecturer_topic' => $lecturer->topic ? $lecturer->topic->topic_name : null,
                    'is_pembimbing' => $history->is_pembimbing,
                    'submission_date' => $history->submission_date->format('d-m-Y'),
                    'response_date' => $history->response_date ? $history->response_date->format('d-m-Y') : null,
                    'response' => $history->response,
                    'students' => [
                        'name'  => $history->student->name,
                    ],
                ];
            });
        });

        return ResponseFormatter::success($data->values());
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
        $application_history = ApplicationHistory::with(['lecturers.topic', 'student'])->findOrFail($id);

        $data = $application_history->lecturers->map(function ($lecturer) use ($application_history) {
            return [
                'id' => $application_history->id,
                'student_id' => $application_history->student->id,
                'student_name' => $application_history->student->name,
                'lecturer_id' => $lecturer->id,
                'lecturer_name' => $lecturer->name,
                'lecturer_code' => $lecturer->code,
                'lecturer_topic' => $lecturer->topic ? $lecturer->topic->topic_name : null,
                'is_pembimbing' => $application_history->is_pembimbing,
                'submission_date' => $application_history->submission_date->format('d-m-Y'),
                'response_date' => $application_history->response_date ? $application_history->response_date->format('d-m-Y') : null,
                'response' => $application_history->response,
            ];
        });

        return ResponseFormatter::success($data->values());
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
        $application_history = ApplicationHistory::with('lecturers.topic')->findOrFail($id);

        $lecturers = $application_history->lecturers->map(function ($lecturer) {
            return [
                'id' => $lecturer->id,
                'name' => $lecturer->name,
                'code' => $lecturer->code,
                'nip' => $lecturer->nip,
                'email' => $lecturer->email,
                'phone' => $lecturer->phone,
                'study_program' => $lecturer->study_program,
                'topic' => $lecturer->topic ? [
                    'id' => $lecturer->topic->id,
                    'topic_name' => $lecturer->topic->topic_name,
                    'description' => $lecturer->topic->description,
                ] : null,
            ];
        });

        return ResponseFormatter::success($lecturers->values());
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
