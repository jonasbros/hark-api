<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\UserPost;

class UserPostController extends Controller
{
    public function get(Request $request, $url) {
        if( Auth::check() ) {
            $posts = UserPost::where('user_id', auth()->user()->id)->get();

            return response()->json([
                'status' => 'success', 
                'posts' => $posts,
            ]);
        }else {
            echo 'no atuhh!';
        }
    }
}
