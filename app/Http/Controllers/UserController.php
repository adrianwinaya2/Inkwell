<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function authenticate(Request $request) {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $remember = $request->has('remember') ? true : false;

        if (auth()->attempt($validated, $remember)) {
            return redirect()->route('index');
        } else {
            return back()->with('error', 'Invalid username or password')->withInput();
        }
    }

    public function create_user(Request $request) {
        $validated = $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);
        $request->session()->regenerate();
        return redirect()->route('post.index');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }

    // API
    public function show(Request $request, $user_id=null) {
        $user = $user_id ? User::find($user_id) : User::all();
        return $user ? response()->json(['user' => $user]) : response()->json(['error' => 'User not found']);
    }
}
