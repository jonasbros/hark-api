<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'store', 'storeGoogle']]);
    }

    public function store(Request $request) {
        try {
            $user = new User();

            $userExists = $user->where('email', $request->email)->first();
            if( $userExists ) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'An account with that email is already registered.',
                ], 422);
            }
            
            $user->display_name    = $request->name;
            $user->name            = $request->name;
            $user->email           = $request->email;
            $user->bio             = NULL;
            $user->websites        = NULL;
            $user->profile_picture = NULL;
            $user->cover_picture   = NULL;
            $user->user_type       = 'user';
            $user->custom_url      = $request->uid;
            $user->birthdate       = NULL;
            $user->last_login      = date('Y-m-d H:i:s');
            
            if( $user->save() ) {
                return response()->json([
                    'status' => 'success', 
                    'message' => 'User registered!',
                ]);            
            }

        }catch(\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage(),
            ]);
        }
    }
}
