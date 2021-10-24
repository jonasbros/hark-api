<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserPostLikes;

class UserPostLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getPostLikes']]);

        $this->userId = auth()->user()->id;
    }

    public function likePost(Request $request) {
        // if user already liked
        $userLiked = UserPostLikes::
                    where('post_id', '=', $request->postId)
                    ->where('user_id', '=', $this->userId)
                    ->count();

        if( $userLiked ) return;

        //else 
        $like = new UserPostLikes();

        $like->user_id = $this->userId;
        $like->post_id = $request->postId;

        if( $like->save() ) {
            return response()->json([
                'status'   => 'success', 
                'message'  => 'Post liked!',
            ], 200);          
        }
    }

    public function unlikePost(Request $request) {
        $unlike = UserPostLikes::
                where('post_id', '=', $request->postId)
                ->where('user_id', '=', $this->userId)
                ->delete();

        if( $unlike ) {
            return response()->json([
                'status'   => 'success', 
                'message'  => 'Post unliked!',
            ], 200);          
        }
    }
}
