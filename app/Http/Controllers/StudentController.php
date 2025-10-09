<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\ResponseFormatter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAllStudent() {
        $students = Student::all();
        return ResponseFormatter::success($students->pluck('api_response'));
    }

    public function showStudent(string $id) {
        $student = Student::findOrFail($id);
        return ResponseFormatter::success($student->api_response);
    }

    public function storeStudent() {
        $validator = validator(request()->all(), $this->getValidation());

         if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $student = Student::create($this->prepareData());
        return $this->showStudent($student->id);
    }

    public function updateStudent(string $id) {
        $student = Student::findOrFail($id);

        $validator = validator(request()->all(), $this->updateValidation());

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $student->update($this->prepareData());
        return $this->showStudent($student->id);
    }

    public function deleteStudent(string $id) {
        $student = Student::findOrFail($id);
        $student->delete();
        return ResponseFormatter::success(null, 'Student deleted');
    }

    public function login() {
         $validator = validator(request()->all(), [
            'username_email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        $student = Student::where('username', request()->username_email)->orWhere('email', request()->username_email)->first();
        if(is_null($student)) {
            return ResponseFormatter::error(400, null, ['Student Not Found']);
        }

        $userPassword = $student->password;
        if(Hash::check(request()->password, $userPassword)) {
            $token = $student->createToken(config('app.name'))->plainTextToken;

            return ResponseFormatter::success(['token' => $token]);
        }

        return ResponseFormatter::error(400, null, ['Wrong Password']);
    }

    public function getValidation() {
        return [
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
        ];
    }

    public function updateValidation() {
        return [
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
        ];
    }

    public function prepareData() {
        $payload = [
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
        return $payload;
    }
}
