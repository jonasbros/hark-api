<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['user']]);
    }

    public function me() {
        return auth()->user();
    }
    
    public function user(Request $request) {
        $custom_url = $request->url;

        $user = User::where('custom_url', $custom_url)->first();

        if( isset($user->id) ) {
            return $user;
        }

        return response()->json([
            'status' => "error",
            'message' => 'user not found'
        ], 404);
    }
}
