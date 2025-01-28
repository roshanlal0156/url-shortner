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
                            <tr>
                                <td>
                                    XYZ corp.
                                    <div class="td-email">example@emai.com</div>
                                </td>
                                <td>
                                    23
                                </td>
                                <td>
                                    345
                                </td>
                                <td>
                                    321
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    XYZ corp.
                                    <div class="td-email">example@emai.com</div>
                                </td>
                                <td>
                                    23
                                </td>
                                <td>
                                    345
                                </td>
                                <td>
                                    321
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    XYZ corp.
                                    <div class="td-email">example@emai.com</div>
                                </td>
                                <td>
                                    23
                                </td>
                                <td>
                                    345
                                </td>
                                <td>
                                    321
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pagination-footer">
                        <div> <span>Showing 2 of total 100 </span> </div>
                        <button>View All</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
