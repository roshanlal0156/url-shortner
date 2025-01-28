@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="invite-client">
            <form id="invite-client-form" action={{ route('sa.invite') }} method="post">
                @csrf
                <label for="name">Name</label>
                <input name="name" id="name" placeholder="eg. XYZ corp." type="text" required>
                <label for="email">Email</label>
                <input name="email" id="email" placeholder="eg. example@email.com" type="email" required>
                <button type="submit">Send Invitation</button>
            </form>
        </div>
    </div>
@endsection
