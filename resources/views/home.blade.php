@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Support Requests') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Device</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody id="supportRequests">
                                @foreach ($supportRequests as $request)
                                    <tr>
                                        <td>{{ $request->requester_name }}</td>
                                        <td>{{ $request->requester_device }}</td>
                                        <td>{{ $request->message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>