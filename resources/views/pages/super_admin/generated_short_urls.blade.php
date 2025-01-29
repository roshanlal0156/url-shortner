@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="super-admin-dashboard-wrapper">
            <div id="s-a-section-1">
                <div id="s-a-section-1-header">
                    <div>Generated Short URLs</div>
                    <div id="download-n-filter">
                        <form method="GET" action="{{ route('sa.generatedShortUrls') }}">
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
                                    Client
                                </th>
                                <th>
                                    Created On
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shortUrls as $url)
                                <tr>
                                    <td><a href="{{ url('/re/' . $url->short_url) }}"
                                            target="_blank">{{ url('/re/' . $url->short_url) }}</a></td>
                                    <td>{{ $url->long_url }}</td>
                                    <td>{{ $url->hits }}</td>
                                    <td>{{ $url->client_name }}</td>
                                    {{-- <td>{{ $url->created_at }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($url->created_at)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    {{-- {{ $shortUrls->appends(request()->query())->links() }} --}}
                    <div class="pagination-footer">
                        <div class="pagination-wrapper">
                            <div> <span>{{ 'Showing ' . $shortUrls->firstItem() . ' to ' . $shortUrls->lastItem() . ' of ' . $shortUrls->total() . ' results' }}
                                </span>
                            </div>
                            <div class="pagination-buttons">
                                @if ($shortUrls->onFirstPage())
                                    <span class="disabled">Previous</span>
                                @else
                                    <a href="{{ $shortUrls->previousPageUrl() }}" class="btn">Previous</a>
                                @endif

                                <!-- Next button -->
                                @if ($shortUrls->hasMorePages())
                                    <a href="{{ $shortUrls->nextPageUrl() }}" class="btn">Next</a>
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
