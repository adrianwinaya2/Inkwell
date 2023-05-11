@extends('layouts.layout_login')

@section('title', 'Register')
@section('title2', 'Register')

@section('form')
    <div class="card-body">
        <form method="POST" action="{{ route('user.create_user') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

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

            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        </form>

        <div class="mt-3 text-center">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
@endsection