<?php

namespace App\Http\Controllers\api\v1\auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\CPU\Helpers;


class PassportAuthController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user_id = $request['email'];
        if (filter_var($user_id, FILTER_VALIDATE_EMAIL)) {
            $medium = 'email';
        } else {
            array_push($errors, ['code' => 'email', 'message' => 'Invalid email address or phone number']);
            return response()->json([
                'errors' => $errors
            ], 403);
        }

        $data = [
            $medium => $user_id,
            'password' => $request->password
        ];

        $user = User::where([$medium => $user_id])->first();

        if (isset($user) && $user->active && auth()->attempt($data)) {
            $user->temporary_token = Str::random(40);
            $user->save();

            $token = auth()->user()->createToken('LaravelAuthApp');

            return response()->json(['token' => $token->plainTextToken], 200);
        } else {
            $errors = [];
            array_push($errors, ['code' => 'auth-001', 'message' => 'Customer_not_found_or_Account_has_been_suspended']);
            return response()->json([
                'errors' => $errors
            ], 401);
        }
    }
}
