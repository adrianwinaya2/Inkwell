<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login() {
        return view('user.login');
    }

    public function authenticate(Request $request) {
        $validated = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($validated)) {
            return redirect()->route('post.all_post');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    public function register() {
        return view('user.register');
    }

    public function create_user(Request $request) {
        $validated = $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        if ($user) {
            return redirect()->route('user.login')->with('success', 'User created successfully');
        } else {
            return redirect()->back()->with('error', 'User creation failed');
        }
    }
}
