<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function check()
    {
        if (!Auth::check()) {
            return view('pages.login');
        }
        $user = Auth::user();
        $role = $user['role'];

        if ($role == 'super_admin') {
            return redirect()->route('sa.dashboard');
        } else if($role == 'admin') {
            return redirect()->route('a.dashboard');
        } else if($role == 'member') {
            return redirect()->route('m.dashboard');
        }
    }

    public function login(Request $request)
    {
        // Validate input data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Attempt authentication
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home'); // Redirect to dashboard if login is successful
        }

        // Redirect back with error message
        return back()->withErrors(['loginError' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
