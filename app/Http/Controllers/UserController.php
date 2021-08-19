<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function me() {
        return auth()->user();
    }

    public function meGoogle(Request $request) {
        $session = Session::where('token', $request->access_token)->first();
        if( $session ) {
            return User::where('id', $session->user_id)->first();
        }
    }
}
