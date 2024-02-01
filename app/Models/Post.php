<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    //posts belong to user
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    //Post has many CategoryPosts
    public function categoryPosts()
    {
        return $this->hasMany(CategoryPost::class);
    }

    // post has many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // post has many likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //return true if $this post is liked by $user
    public function isLikedBy()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        //this->likes = get all likes of $this post
        //where()= in the likes table , find records with user_id = loggen-in user(auth user)
        //exsists()= return true if where() finds existing records
    }
}
