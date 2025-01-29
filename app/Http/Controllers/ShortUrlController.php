<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShortUrlController extends Controller
{
    public function getGenerateShortUrlForm()
    {
        return view('pages.generate_short_url');
    }

    public function generate(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'long_url' => 'required|url'
        ]);

        $shortUrl = ShortUrl::where('long_url', $request->long_url)->where('created_by', Auth::user()->id)->first();
        if (isset($shortUrl) && isset($shortUrl->short_url)) {
            return view('pages.generate_short_url', ['shortUrl' => url('/re/' . $shortUrl->short_url)]);
        }

        // Generate a unique short URL code
        do {
            $shortCode = Str::random(6); // Generate a 6-character random string
        } while (ShortUrl::where('short_url', $shortCode)->exists());

        // Create the short URL entry
        $shortUrl = ShortUrl::create([
            'long_url'   => $request->long_url,
            'short_url'  => $shortCode,
            'hits'       => 0,
            'created_by' => Auth::id(), // Store user ID if authenticated
        ]);

        return view('pages.generate_short_url', ['shortUrl' => url('/re/' . $shortUrl->short_url)]);
    }

    public function redirect($shortUrlCode)
    {
        $shortUrl = ShortUrl::where('short_url', $shortUrlCode)->firstOrFail();

        // Increment the hits count
        $shortUrl->increment('hits');

        // Redirect to the original long URL
        return redirect($shortUrl->long_url);
    }

    public function fetch() {
        return ShortUrl::paginate(10);
    }
}
