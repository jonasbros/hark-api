<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\UserPost;
use App\Models\UserPostLikes;


class UserPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['get', 'getPostLikes']]);
    }

    public function get(Request $request, $url) {

        $userId = User::where('custom_url', $url)->first()->id;

        $posts = DB::table('user_posts')
                ->join('users', 'users.id', '=', 'user_posts.user_id')
                ->select('users.display_name', 'user_posts.*')
                ->where('users.id', '=', $userId)
                ->orderBy('created_at', 'DESC')
                ->paginate($request->perPage);

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

        $user = auth()->user();
        $post = new UserPost();
        
        $post->user_id        = $user->id;
        $post->body           = $request->postContent;
        $post->upload_url     = $request->uploads;
        $post->featured_image = $request->featuredImage;
        $post->hashtags       = $request->hashtags;

        if( $post->save() ) {
            $newPost = DB::table('user_posts')
                        ->join('users', 'users.id', '=', 'user_posts.user_id')
                        ->select('users.display_name', 'user_posts.*')
                        ->where('user_posts.id', '=', $post->id)                           
                        ->get();

            return response()->json([
                'status' => 'success', 
                'post'   => $newPost,
            ], 200);
        }

        return response()->json([
            'status' => 'error', 
            'post'   => 'Oops! Something went wrong.',
        ], 500);
    }

    public function likePost(Request $request) {
        // if user already liked
        $userLiked = UserPostLikes::
                    where('post_id', '=', $request->postId)
                    ->where('user_id', '=', $request->userId)
                    ->count();

        if( $userLiked ) return;

        //else 
        $userId = auth()->user()->id;
        $like = new UserPostLikes();

        $like->user_id = $userId;
        $like->post_id = $request->postId;

        if( $like->save() ) {
            return response()->json([
                'status'   => 'success', 
                'message'  => 'Post liked!',
            ], 200);          
        }
    }

    public function unlikePost(Request $request) {
        $userId = auth()->user()->id;
        $unlike = UserPostLikes::
                where('post_id', '=', $request->postId)
                ->where('user_id', '=', $userId)
                ->delete();

        if( $unlike ) {
            return response()->json([
                'status'   => 'success', 
                'message'  => 'Post unliked!',
            ], 200);          
        }
    }

    public function getPostLikes(Request $request) {
        $likes     = UserPostLikes::where('post_id', '=', $request->postId)->count();

        $userLiked = UserPostLikes::
                    where('post_id', '=', $request->postId)
                    ->where('user_id', '=', $request->userId)
                    ->count();

        return response()->json([
            'likes'     => $likes,
            'userLiked' => $userLiked
        ], 200); 
    }
    

}


