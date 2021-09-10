<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\UserPost;
use App\Models\User;


class UserPostController extends Controller
{
    public function get(Request $request, $url, $perpage) {

        $userId = User::where('custom_url', $url)->first()->id;

        if( Auth::check() ) {
            $posts = UserPost::where('user_id', $userId)->limit($perpage)->get();

            return response()->json([
                'status' => 'success', 
                'posts' => $posts,
            ], 200);
        }

        return response()->json([
            'status' => 'error', 
            'message' => 'Unauthorized!',
        ], 401);

    }
}
