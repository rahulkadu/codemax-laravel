<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Auth;
use Dingo\Api\Routing\Helpers;
use Hash;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use JWTAuth;
use Validator;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'username' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = implode(' ', $validator->errors()->all());
            return response()->json(['message' => $errors], 401);
        }

        $credentials = request(['username', 'password']);
        
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials.'], 401);
        }

        return response()->json([
            'token' => $token,
            'type' => 'bearer', 
            'expires' => auth('api')->factory()->getTTL() * 60, 
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|unique:users'
        ]);

        if ($validator->fails()) {

            $errors = implode(' ', $validator->errors()->all());
            return response()->json(['message' => $errors], 401);
        }

        $user = new User();
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return response()->json(['success' => 1]);
    }
    public function sss(Request $request)
    {
        dd('gsdf');
    }
    public function asd(Request $request)
    {
        dd('sss');
    }
}
