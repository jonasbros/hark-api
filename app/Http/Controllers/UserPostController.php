<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\UserPost;
use App\Models\User;


class UserPostController extends Controller
{
    public function get(Request $request, $url, $perpage) {

        $userId = User::where('custom_url', $url)->first()->id;

        $posts = DB::table('user_posts')
                ->join('users', 'users.id', '=', 'user_posts.user_id')
                ->select('users.display_name', 'user_posts.*')
                ->where('custom_url', '=', $url)
                ->orderBy('created_at', 'DESC')
                ->limit($perpage)
                ->get();

        return response()->json([
            'status' => 'success', 
            'posts' => $posts,
        ], 200);

    }

    public function storeBase(Request $request) {
        if( !$request->postContent ) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Post is empty :(',
            ], 200);
        }

        if( Auth::check() ) {
            $user = auth()->user();
            $post = new UserPost();
            
            $post->user_id = $user->id;
            $post->body    = $request->postContent;

            if( $post->save() ) {
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Post successful!',
                ], 200);
            }
        }
    }

}


