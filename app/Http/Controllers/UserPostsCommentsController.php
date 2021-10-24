<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\UserPostsComments;

class UserPostsCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getPostComments']]);
        $this->user = auth()->user();
    }

    public function storeBaseComment(Request $request) {
        if( !$request->commentContent ) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Post is empty :(',
            ], 200);
        }

        $comment = new UserPostsComments();
        
        $comment->user_id        = $this->user->id;
        $comment->post_id        = $request->postId;
        $comment->body           = $request->commentContent;
        
        if( $comment->save() ) {
            $newComment = DB::table('user_posts_comments')
                        ->join('users', 'users.id', '=', 'user_posts_comments.user_id')
                        ->select('users.display_name', 'user_posts_comments.*')
                        ->where('user_posts_comments.id', '=', $comment->id)                           
                        ->get();

            return response()->json([
                'status'    => 'success', 
                'comment'   => $newComment,
            ], 200);
        }

        return response()->json([
            'status' => 'error', 
            'post'   => 'Oops! Something went wrong.',
        ], 500);
    }

    public function getPostComments(Request $request) {
        $comments  = UserPostsComments::with('likes')
                    ->join('users', 'users.id', '=', 'user_posts_comments.user_id')
                    ->select('users.display_name', 'user_posts_comments.*')
                    ->where('user_posts_comments.post_id', '=', $request->postId)  
                    ->orderBy('created_at', 'DESC')
                    ->paginate($request->perPage)
                    ->toArray();     

        //check if auth user liked comment
        foreach($comments['data'] as $c => $comment) {
            $comments['data'][$c]['userLiked'] = false;

            foreach($comment['likes'] as $l => $like) {
                if( $like['user_id'] == $this->user->id ) {
                    $comments['data'][$c]['userLiked'] = true;
                }
            }
        }

        return response()->json([
            'comments'     => $comments,
        ], 200); 
    }

}
