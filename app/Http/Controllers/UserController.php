<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
     * Show resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => User::all()
        ]);
    }

    /**
     * Show specific resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => User::find($id)
        ]);
    }

    /**
     * Store new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $payload = $request->all();
        $payload['password'] = Hash::make($request->password);
        $response = User::create($payload);

        if ($response) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resource added successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unable to create resource'
            ]);
        }
    }

    /**
     * Update the given resource.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $payload = $request->all();
        if (isset($payload['password']) && ! empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }
        $response = User::findOrFail($request->user_id)->update($payload);
        if ($response) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resource updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unable to update resource'
            ]);
        }
    }

    /**
     * Delete the given resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    { 
        $response = User::destroy($request->user_id);

        if ($response) {
            return response()->json([
                'status' => 'success',
                'message' => 'Resource has been successfully deleted',
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Unable to delete resource'
            ]);
        }
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => User::where($request->key, $request->value)->first()
        ]);
    }
}
