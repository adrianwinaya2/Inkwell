@extends('layouts.layout')

@section('title')
    @yield('title')
@endsection

@section('body')
    <div class="container mt-5">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">

                        <div class="card-header">
                            <h3>@yield('title2')</h3>
                        </div>

                        @yield('form')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection