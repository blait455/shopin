<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable=[
        'post_id',
        'user_id'
    ];
    
	public function post()
	{	
		return $this->belongsTo(Post::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

    public function likeUser(){
        return $this->belongsTo(User::class, 'user_id','id')->select('id','name','image');
    }

	public static function likers($id){
		
		$post=Post::find($id);
   		$likers= $post->likes;
   		$likerarr = array();
   		foreach($likers as $liker)
   		{
   			$user=$liker->user;
   			array_push($likerarr,$user);
   		}
   		return $likerarr;
   	}
}
