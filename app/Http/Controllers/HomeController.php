<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // returns current logged in user id
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        // easily fetch all posts of this logged in user because of the relationship we added betn Models
        $posts = $user->posts;
        return view('home')->with('posts', $posts);
    }
}
