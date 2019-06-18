<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
            'data' => Review::all()
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
            'data' => Review::find($id)
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
            'user_id' => 'required',
            'remedie_id' => 'required',
            'rating' => 'required',
            'description' => 'required',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $payload = $request->all();
        $response = Review::create($payload);

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
        $response = Review::findOrFail($request->id)->update($payload);
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
        $response = Review::destroy($request->id);

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
            'data' => Review::where($request->key, $request->value)->first()
        ]);
    }
}
