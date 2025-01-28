@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Sembark URL Shortner', 'showLogout' => false])
        <div id="login-form-wrapper">
            <form id="login-form" action={{ route('login') }} method="post">
                @csrf
                <label for="email">Email</label>
                <input name="email" id="email" placeholder="eg. example@email.com" type="email" required>
                @if ($errors->has('loginError'))
                    <span class="input-error">{{ $errors->first('loginError') }}</span>
                @endif
                <label for="password">Password</label>
                <input name="password" id="password" placeholder="*************" type="password" required>
                @if ($errors->has('loginError'))
                    <span class="input-error">{{ $errors->first('loginError') }}</span>
                @endif
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection
