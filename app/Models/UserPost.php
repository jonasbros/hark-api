<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    protected $table = 'user_posts';
    protected $primaryKey = 'id';
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(UserPostLikes::class, 'post_id');
    }

    public function comments() {
        return $this->hasMany(UserPostComments::class);
    }
}
