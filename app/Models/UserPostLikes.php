<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPostLikes extends Model
{

    protected $table = 'user_post_likes';

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post() {
        return $this->belongsTo(UserPost::class);
    }
}
