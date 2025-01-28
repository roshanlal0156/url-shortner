<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function check() {
        if(!Auth::check()) {
            return view('pages.login');
        }
        $user = Auth::user();
        $role = $user['role'];

        if($role == 'super_admin') {
            return view('pages.super_admin.dashboard');
        }
    }

    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        Validator::validate($data, ["email" => "required|string", "password" => "required|string"]);
        if(Auth::attempt($data)) {
            $user = Auth::user();
            return route('sa.dashboard');
        }
        return back()->withErrors(['loginError' => 'Invalid credentials']);
    }
}
