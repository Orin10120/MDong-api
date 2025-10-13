<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\ResponseFormatter;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with('student');
        
        // Filter JIKA ada parameter student_id
        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }
        
        // Jika TIDAK ada parameter → ambil semua (seperti Project::all())
        $projects = $query->get();
        
        return ResponseFormatter::success($projects->pluck('api_response')->values());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'student_id'     => 'required|exists:students,id',
            'project_type'   => 'required|string|in:Perancangan,Analisa',
            'project_name'   => 'required|string|max:255',
            'visual_path'    => 'required|image',
            'technique'      => 'required|string|max:150',
            'method'         => 'required|string|max:200',
            'material'      => 'required|string|max:100',
            'narration'     => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $project = Project::create($this->prepareData());
        return $this->show($project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return ResponseFormatter::success($project->api_response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validator = validator($request->all(), [
            'student_id'     => 'sometimes|exists:students,id',
            'project_type'   => 'sometimes|string|in:Perancangan,Analisa',
            'project_name'   => 'sometimes|string|max:255',
            'visual_path'    => 'sometimes|image',
            'technique'      => 'sometimes|string|max:150',
            'method'         => 'sometimes|string|max:200',
            'material'      => 'sometimes|string|max:100',
            'narration'     => 'sometimes|string|max:1000',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $project->update($this->prepareData());
        return $this->show($project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return ResponseFormatter::success(null, 'Project deleted');
    }


    public function prepareData() {
        $payload = [
            'student_id'     => request()->student_id,
            'project_type'   => request()->project_type,
            'project_name'   => request()->project_name,
            'technique'      => request()->technique,
            'method'         => request()->method,
            'material'      => request()->material,
            'narration'     => request()->narration,
        ];

        if (!is_null(request()->visual_path)) {
            $payload['visual_path'] = request()->file('visual_path')->store('projects', 'public');
        }
        return $payload;
    }
}
