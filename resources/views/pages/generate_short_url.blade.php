@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="generate-short-url">
            <form id="generate-short-url-form" action={{ route('generate') }} method="post">
                @csrf
                <label for="longurl">Long URL</label>
                <input name="long_url" id="longurl" placeholder="enter long url ..." type="text" required>
                <button type="submit">Generate</button>
            </form>
            <div>
                @if (isset($shortUrl))
                    <p>Short URL: <a href="{{ $shortUrl }}" target="_blank">{{ $shortUrl }}</a></p>
                @endif
            </div>
        </div>
    </div>
@endsection
