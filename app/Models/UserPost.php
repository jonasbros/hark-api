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

    public function likes() {
        return $this->hasMany(UserPostLikes::class);
    }
}
