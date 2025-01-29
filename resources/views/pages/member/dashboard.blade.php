@extends('layouts.app')

@section('title', 'Sembark')

@section('content')
    <div id="page-container">
        @include('components/header', ['pageTitle' => 'Dashboard', 'showLogout' => false])
        <div id="admin-generated-short-urls">
            <div id="a-section-1">
                <div id="a-section-1-header">
                    <div>Gnerated Short URLs <a href="{{ route('generate-form') }}">Generate</a></div>

                    {{-- <button>Invite</button> --}}
                    {{-- <a href={{ route('a.inviteform') }}>Download</a> --}}
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
                                    <td>{{ $url->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
