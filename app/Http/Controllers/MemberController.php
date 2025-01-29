<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        $shortUrls = ShortUrl::with('createdBy')->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10); // 10 per page

        return view('pages.member.dashboard', compact('shortUrls'));
    }
}
