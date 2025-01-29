@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="admin-generated-short-urls">
            <div id="a-section-1">
                <div id="a-section-1-header">
                    <div>Team Members</div>

                    {{-- <button>Invite</button> --}}
                    <a href={{ route('a.inviteform') }}>Invite</a>
                </div>
                <div id="clients-list">
                    <div id="clients-list">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Role
                                    </th>
                                    <th>
                                        Total Generated URLs
                                    </th>
                                    <th>
                                        Total URL Hits
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ $member->role }}</td>
                                        <td>{{ $member->total_urls }}</td>
                                        <td>{{ $member->total_hits ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-footer">
                            <div class="pagination-wrapper">
                                <div> <span>{{ 'Showing ' . $members->firstItem() . ' to ' . $members->lastItem() . ' of ' . $members->total() . ' results' }}
                                    </span>
                                </div>
                                <div class="pagination-buttons">
                                    @if ($members->onFirstPage())
                                        <span class="disabled">Previous</span>
                                    @else
                                        <a href="{{ $members->previousPageUrl() }}" class="btn">Previous</a>
                                    @endif

                                    <!-- Next button -->
                                    @if ($members->hasMorePages())
                                        <a href="{{ $members->nextPageUrl() }}" class="btn">Next</a>
                                    @else
                                        <span class="disabled">Next</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
