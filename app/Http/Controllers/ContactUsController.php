<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;
use Auth;
use JWTAuth;
use Validator;

class ContactUsController extends Controller
{
    public function submitContactUs(Request $request)
    {
    	$user = auth()->user();
    	// dd($user);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = implode(' ', $validator->errors()->all());
            return response()->json(['message' => $errors], 401);
        }

        $insert = new ContactUs();
        $insert->email = $request->get('email');
        $insert->user_id = $user->id;
        $insert->message = $request->get('message');
        $insert->save();

        return response()->json(['success' => 1]);
    }
}
