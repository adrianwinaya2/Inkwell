<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ViewController extends Controller
{
    public function index()
    {
        // $client = new Client();
        // $posts = $client->get(route('post.all_post'));
        // $posts = Http::timeout(60)->get(route('post.all_post'))->json();
        return view('index');
    }
    public function login() {
        return view('login');
    }
    public function register() {
        return view('register');
    }

    public function new_post() {
        return view('create_post');
    }

    public function view_post($id) {
        return view('view_post', ['id' => $id]);
    }
}
