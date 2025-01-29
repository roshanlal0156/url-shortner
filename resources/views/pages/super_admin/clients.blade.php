@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="super-admin-dashboard-wrapper">
            <div id="s-a-section-1">
                <div id="s-a-section-1-header">
                    <div>Clients</div>
                    {{-- <button>Invite</button> --}}
                    <a href={{ route('sa.inviteform') }}>Invite</a>
                </div>
                <div id="clients-list">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    Client Name
                                </th>
                                <th>
                                    Users
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
                            @foreach ($clients as $client)
                                <tr>
                                    <td>
                                        {{ $client->name }}
                                        <div class="td-email">{{ $client->email }}</div>
                                    </td>
                                    <td>{{ $client->total_users }}</td>
                                    <td>{{ $client->total_urls }}</td>
                                    <td>{{ $client->total_hits ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-footer">
                        <div class="pagination-wrapper">
                            <div> <span>{{ 'Showing ' . $clients->firstItem() . ' to ' . $clients->lastItem() . ' of ' . $clients->total() . ' results' }}
                                </span>
                            </div>
                            <div class="pagination-buttons">
                                @if ($clients->onFirstPage())
                                    <span class="disabled">Previous</span>
                                @else
                                    <a href="{{ $clients->previousPageUrl() }}" class="btn">Previous</a>
                                @endif

                                <!-- Next button -->
                                @if ($clients->hasMorePages())
                                    <a href="{{ $clients->nextPageUrl() }}" class="btn">Next</a>
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
