@extends('layouts.layout_login')

@section('title', 'Login')
@section('title2', 'Login')

@section('form')
    <div class="card-body">
        <form method="POST" action="{{ route('user.authenticate') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            {{-- <p>{{ $error ? $error : '' }}</p> --}}

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        

        <div class="mt-3 text-center">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
@endsection