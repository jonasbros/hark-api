<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPostsComments extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(UserPost::class);
    }

    public function likes() {
        return $this->hasMany(UserPostCommentsLikes::class, 'comment_id');
    }
}
