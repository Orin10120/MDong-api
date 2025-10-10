<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\ResponseFormatter;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return ResponseFormatter::success($students->pluck('api_response'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name'             => 'required|string|max:255',
            'student_number'   => 'required|integer',
            'username'         => 'required|string|max:50',
            'email'            => 'required|string|email|max:50',
            'password'         => 'required|string|min:8',
            'phone_number'     => 'nullable|string|max:15',
            'major'            => 'required|string|max:100',
            'class'            => 'required|string|max:10',
            'entry_year'       => 'required|integer|min:2000|max:2100',
            'social_media_url' => 'nullable|url|max:255',
            'status'           => 'required|in:DRAFT,APPLIED,APPROVED-1,APPROVED-FULL,FINISHED',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $student = Student::create([
            'name' => request()->name,
            'student_number' => request()->student_number,
            'username' => request()->username,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'phone_number' => request()->phone_number,
            'major' => request()->major,
            'class' => request()->class,
            'entry_year' => request()->entry_year,
            'social_media_url' => request()->social_media_url,
            'status' => request()->status,
        ]);

        return $this->show($student->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        return ResponseFormatter::success($student->api_response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $validator = validator($request->all(), [
            'name'             => 'sometimes|string|max:255',
            'student_number'   => 'sometimes|integer',
            'username'         => 'sometimes|string|max:50',
            'email'            => 'sometimes|string|email|max:50',
            'password'         => 'sometimes|string|min:8',
            'phone_number'     => 'nullable|string|max:15',
            'major'            => 'sometimes|string|max:100',
            'class'            => 'sometimes|string|max:10',
            'entry_year'       => 'sometimes|integer|min:2000|max:2100',
            'social_media_url' => 'nullable|url|max:255',
            'status'           => 'sometimes|in:DRAFT,APPLIED,APPROVED-1,APPROVED-FULL,FINISHED',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $data = [
            'name' => request()->name,
            'student_number' => request()->student_number,
            'username' => request()->username,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'phone_number' => request()->phone_number,
            'major' => request()->major,
            'class' => request()->class,
            'entry_year' => request()->entry_year,
            'social_media_url' => request()->social_media_url,
            'status' => request()->status,
        ];


        $student->update($data);
        return $this->show($student->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return ResponseFormatter::success(null, 'Student deleted');
    }
}
