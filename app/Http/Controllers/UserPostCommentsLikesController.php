<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserPostCommentsLikes;


class UserPostCommentsLikesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['getPostLikes']]);
    }

    public function likePostComment(Request $request) {
        $userId = auth()->user()->id;
        // if user already liked
        $userLiked = UserPostCommentsLikes::
                    where('post_id', '=', $request->postId)
                    ->where('user_id', '=', $userId)
                    ->count();

        if( $userLiked ) return;

        //else 
        $like = new UserPostCommentsLikes();

        $like->user_id    = $userId;
        $like->post_id    = $request->postId;
        $like->comment_id = $request->commentId;

        if( $like->save() ) {
            return response()->json([
                'status'   => 'success', 
                'message'  => 'Post liked!',
            ], 200);          
        }
    }

    public function getPostCommentLikes(Request $request) {
        $likes     = UserPostCommentsLikes::where('comment_id', '=', $request->postId)->count();

        $userLiked = UserPostCommentsLikes::
                    where('comment_id', '=', $request->postId)
                    ->where('user_id', '=', $this->userId)
                    ->count();

        return response()->json([
            'likes'     => $likes,
            'userLiked' => $userLiked
        ], 200); 
    }
}
