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
    
    public function user(Request $request) {
        $value = ($request->email ? $request->email : $request->url);
        $column = ($request->email ? 'email' : 'custom_url');
        
        $user = User::where($column, $value)->first();

        if( isset($user->id) ) {
            return response()->json([
                'status' => "success",
                'user' => $user
            ], 200);
        }

        return response()->json([
            'status' => "error",
            'message' => 'user not registered'
        ], 404);
    }
}
