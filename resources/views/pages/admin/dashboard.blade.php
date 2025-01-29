@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="admin-dashboard-wrapper">
            <div id="a-section-1">
                <div id="a-section-1-header">
                    <div>Gnerated Short URLs <a href="{{ route('generate-form') }}">Generate</a></div>
                    <div id="download-n-filter">
                        <form method="GET" action="{{ route('a.dashboard') }}">
                            <select name="duration" id="duration" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="today" {{ request('duration') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="last_week" {{ request('duration') == 'last_week' ? 'selected' : '' }}>Last
                                    Week</option>
                                <option value="last_month" {{ request('duration') == 'last_month' ? 'selected' : '' }}>Last
                                    Month</option>
                            </select>
                            <button id="download" type="submit" name="download" value="1">Download</button>
                        </form>
                    </div>
                </div>
                <div id="clients-list">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    Short URL
                                </th>
                                <th>
                                    Long URL
                                </th>
                                <th>
                                    Hits
                                </th>
                                <th>
                                    Created By
                                </th>
                                <th>
                                    Created On
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shortUrls as $url)
                                <tr>
                                    <td>{{ $url->long_url }}</td>
                                    <td><a href="{{ url('/re/' . $url->short_url) }}"
                                            target="_blank">{{ url('/re/' . $url->short_url) }}</a></td>
                                    <td>{{ $url->hits }}</td>
                                    <td>{{ $url->createdBy ? $url->createdBy->name : 'Unknown' }}</td>
                                    <td>{{ $url->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-footer">
                        <div> <span>{{     "Showing " . $shortUrls->firstItem() . " to " . $shortUrls->lastItem() . " of " . $shortUrls->total() . " results" }} </span> </div>
                        <a href="{{ route('a.generateShortUrls') }}">View All</a>
                    </div>
                </div>
            </div>


            <br>
            <br>
            <br>
            <div id="a-section-1">
                <div id="a-section-1-header">
                    <div>Team Members </div>

                    {{-- <button>Invite</button> --}}
                    <a href={{ route('a.inviteform') }}>Invite</a>
                </div>
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
                                    <td>{{ $member->email}}</td>
                                    <td>{{ $member->role}}</td>
                                    <td>{{ $member->total_urls }}</td>
                                    <td>{{ $member->total_hits ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-footer">
                        <div> <span>{{     "Showing " . $members->firstItem() . " to " . $members->lastItem() . " of " . $members->total() . " results" }} </span> </div>
                        <a href="{{ route('a.members') }}">View All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
