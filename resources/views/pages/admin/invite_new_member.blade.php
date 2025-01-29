@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="invite-member">
            <form id="invite-member-form" action={{ route('a.invite') }} method="post">
                @csrf
                <label for="name">Name</label>
                <input name="name" id="name" placeholder="eg. XYZ corp." type="text" required>
                <label for="email">Email</label>
                <input name="email" id="email" placeholder="eg. example@email.com" type="email" required>
                <label for="role">Role</label>
                <select name="role" id="role">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Send Invitation</button>
            </form>
        </div>
    </div>
@endsection
