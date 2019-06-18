<?php

namespace App\Http\Controllers;

use App\Tip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TipController extends Controller
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
            'data' => Tip::all()
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
            'data' => Tip::find($id)
        ]);
    }

    /**
     * Store new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
       'user_id',
        'title',
        'description',
        'picture',
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required|unique:tips',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        $payload = $request->all();
        
        if ( ! empty($request->picture) ) {
            $payload['picture'] = "uploads/tips/cp_".time().".jpg";
            $path = base_path('public/'.$payload['picture']);
            file_put_contents($path, base64_decode($request->picture));
        }
        
        $response = Tip::create($payload);
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
        $response = Tip::findOrFail($request->id)->update($payload);
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

 
    public function destroy(Request $request)
    { 
        $response = Tip::destroy($request->id);

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
            'data' => Tip::where($request->key, $request->value)->first()
        ]);
    }
}
