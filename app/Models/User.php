<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Like;
use App\Models\Message;
use App\Models\Blockuser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'gender',
        'clocation',
        'ccountry',
        'about',
        'image',
        'username',
        'password',
        'cover_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function posts(){

        return $this->hasMany(Post::class)->orderBy('created_at','desc');
    }

    public function comments(){

        return $this->hasMany(Comment::class);
    }

    public function photos(){

        return $this->hasMany(Photo::class);
    }

    public function follow()
    {
      return $this->belongsToMany(User::class, 'user_follows', 'user_id', 'follow_id');
    }

    public function followers()
    {
      $blockUsers = $this->hasMany(Blockuser::class)->get()->toArray();
      return $this->belongsToMany(User::class, 'user_follows', 'follow_id', 'user_id');


      // dd($blockUsers);
      // foreach($followers as $follower)
      {

      }
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function block_users()
    {
      return $this->hasMany(Blockuser::class);
    }

    public function getImagePathAttribute()
    {
        return url('images/'.$this->attributes['image']);
      // Rest omitted for brevity
    }
    protected $appends =
    [
        'image_path'
    ];
}
