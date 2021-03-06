<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Message;
use App\Models\User_follow;
use Illuminate\Http\Request;

class usersController extends Controller
{
    public function index($id)
    {
        $Like= new Like;
        $Post = new Post;
        $User = new User;
    	$user = User::find($id);
    	if($user->id === Auth::id()){
            return redirect('profile');            
		}else{
            $already_follow= User_follow::where(['user_id' => Auth::id(),'follow_id' => $id])->first();
            if(is_null($already_follow))
            {
                $status= "Follow"; 
            }else{
                $status= "Un follow";
            }
			$posts = Post::where('user_id',$id)->orderBy('created_at','desc')->paginate(4);
            if (request()->ajax()) {
                $view = view('home.posts',compact('posts','followings','Like','Post','User'))->render();
                
                return response()->json(['html'=>$view]);
            }
            $followings=$user->follow;

			return view('user.profile',compact('posts','user','status','followings','Like','User','Post'));
		}

    }

    public function showphotos($id){
        $already_follow= User_follow::where(['user_id' => Auth::id(),'follow_id' => $id])->first();
        if(is_null($already_follow))
        {
            $status= "Follow"; 
        }else{
            $status= "Un follow";
        }
    	$user = User::find($id);
    	$photos= $user->photos;
        $followings=$user->follow;

    	return view('user.photos',compact('photos','user','status','followings'));
    }
}
