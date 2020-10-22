<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'post_id',
        'photo',
        'extension'
    ];

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function user(){

    	return $this->belongsTo(User::class);
    }
}
