<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'post_id',
        'body',
    ];

    public function post(){
    	return $this->belongsTo(Post::class)->orderBy('created_at','asc');
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function commentUser()
    {
        return $this->belongsTo(User::class,'user_id','id')->select('id','name','image');
    }
}
