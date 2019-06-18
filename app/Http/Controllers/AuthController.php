<?php

namespace App\Http\Controllers;

use App\User;
use App\Remedie;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Login handler.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (!empty($user) && password_verify($request->password, $user->password)) {

            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);

        } else {

            return response()->json([
                'status' => 'fail',
                'message' => 'Authentication failed.'
            ]);
        }
    }

}
