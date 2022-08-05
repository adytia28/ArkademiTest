<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:8',
        ]);

        // return $request;

        if(!$token = Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return response(null, 401);
        }

        $user = User::where('username', $request->username)->first();
        $user->token = $token;
        $user->save();

        return response()->json([
            'error' => false,
            'data' => $user
        ]);
    }
}
