<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPostCommentsLikes extends Model
{   
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comment() {
        return $this->belongsTo(UserPostComments::class, 'post_id');
    }
}
