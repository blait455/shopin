<?php

namespace App\Http\Controllers;

use Auth;
use Carbon;
use App\Models\Post;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;

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
        return view('home');
    }

    public function home(Request $request)
    {
        $posts= Post::getfeed(Auth::id())->orderBy('created_at','desc')->paginate(5);
        $Like= new Like;
        $Post = new Post;
        $User = new User;
        if ($request->ajax()) {
            $view = view('home.posts',compact('posts','Like','Post','User'))->render();
            return response()->json(['html'=>$view]);
        }
         return view('home.index',compact('posts','Like','Post','User'));
        
    }
}
