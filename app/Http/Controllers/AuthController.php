<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $validator = validator($request->all(), [
            'email'    => 'required|string|email|max:50',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }

        if(Auth::guard('dosen')->attempt($validator->validated())) {
            $dosen = Auth::guard('dosen')->user();
            $request->session()->regenerate();

            return ResponseFormatter::success([
                'nama' => $dosen->name,
                'role' => 'dosen',
            ], 'Login successful');
        }

        if(Auth::guard('mahasiswa')->attempt($validator->validated())) {
            $mahasiswa = Auth::guard('mahasiswa')->user();
            $request->session()->regenerate();

            return ResponseFormatter::success([
                'user' => $mahasiswa->api_response,
                'role' => 'mahasiswa',
            ], 'Login successful');
        }

        return ResponseFormatter::error(401, $validator->errors());
    }


    public function logout(Request $request) {

        if(Auth::guard('dosen')->check()) {
            Auth::guard('dosen')->logout();
        }

        if(Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ResponseFormatter::success(null, 'Logout successful');
    }
}
