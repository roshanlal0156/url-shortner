<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function testCreate() {
        User::create([
            'name' => 'Admin User',
            'email' => 'roshanlal0156@gmail.com',
            'password' => bcrypt('adminpassword'),
            'role' => 'super_admin',
            'client_id' => 0
        ]);
    }

    public function dashboard() {
        return view('pages.super_admin.dashboard');
    }

    public function getInviteForm() {
        return view('pages.super_admin.invite_new_client');
    }

    public function invite() {
        // create entry in clients table

        // send username and password over email
    }
}
