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
            
            $password = $request->password;
            $hashedPassword = Hash::make($request->password, [
                'rounds' => 14,
            ]);

            $user->display_name    = $request->name;
            $user->name            = $request->name;
            $user->email           = $request->email;
            $user->bio             = NULL;
            $user->websites        = NULL;
            $user->profile_picture = NULL;
            $user->cover_picture   = NULL;
            $user->password        = $hashedPassword;
            $user->user_type       = 'user';
            $user->custom_url      = time();
            $user->birthdate       = NULL;
            $user->last_login      = date('Y-m-d H:i:s');
            
            if( $user->save() ) {
                $request->password = $password;
                $this->login($request);
            }

        }catch(\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function storeGoogle(Request $request) {       
        try {
            $user = new User();

            $existingUser = $user->where('email', $request->email)->first();
            // login if exists
            if( $existingUser ) {
                $this->storeGoogleSession($existingUser->id, $request->token);
            }else {
                $user->display_name    = $request->name;
                $user->name            = $request->name;
                $user->email           = $request->email;
                $user->bio             = NULL;
                $user->websites        = NULL;
                $user->profile_picture = $request->picture;
                $user->cover_picture   = NULL;
                $user->password        = NULL;
                $user->user_type       = 'user';
                $user->custom_url      = time();
                $user->birthdate       = NULL;
                $user->last_login      = date('Y-m-d H:i:s');
    
                if( $user->save() ) {
                    $this->storeGoogleSession($user->id(), $request->token);
                }
            }
        }catch(\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => $e->getMessage(),
            ]);
        }
    }//storeGoogle
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $email = $request->email;
        $password = $request->password;

        if( empty($email) || empty($password) && $password !== null ) {

            echo json_encode([
                'status' => 'error', 
                'message' => 'You must fill all the fields.',
            ]);
        }

        $credentials = request(['email', 'password']);
        if ( !$token = auth()->attempt($credentials) ) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        echo json_encode([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);    
    }

    // unused for now
    protected function storeGoogleSession($user_id, $token) {
        try {
            $session = new Session();

            $userSessionExists = $session->where('user_id', $user_id)->first();
            if( $userSessionExists ) {
                $userSessionExists->delete();
            }

            if( $session->firstOrCreate(['user_id' => $user_id, 'token' => $token]) ) {
                echo json_encode([
                    'status'  => 'success',
                    'message' => 'User logged in!',
                ]);
            }
        }catch(\Exception $e) {
            echo json_encode([
                'status' => 'error', 
                'message' => $e->getMessage(),
            ]);
        }

    }

}
