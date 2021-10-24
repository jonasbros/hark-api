<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\UserPost;
use App\Models\UserPostLikes;
use App\Models\UserPostsComments;


class UserPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['get']]);
    }

    public function get(Request $request, $url) {

        $userId = User::where('custom_url', $url)->first()->id;

        $posts = UserPost::with('likes')
                            ->join('users', 'users.id', '=', 'user_posts.user_id')
                            ->select('users.display_name', 'users.profile_picture', 'user_posts.*')
                            ->where('users.id', '=', $userId)
                            ->orderBy('created_at', 'DESC')
                            ->paginate($request->perPage)
                            ->toArray();


        //check and save if auth user has liked the post
        $postsCount = count($posts['data']);
    
        for( $i = 0; $i < $postsCount; $i++ ) {
            $likesCount = count($posts['data'][$i]['likes']);
            $posts['data'][$i]['userLiked'] = false;

            for( $n = 0; $n < $likesCount; $n++ ) {
                $likeUserId = $posts['data'][$i]['likes'][$n]['user_id'];

                if( $likeUserId == $userId ) {
                    $posts['data'][$i]['userLiked'] = true;
                }
            }            
        }

        return response()->json([
            'status'      => 'success', 
            'posts'       => $posts
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
                        ->select('users.display_name', 'users.profile_picture', 'user_posts.*')
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

}


