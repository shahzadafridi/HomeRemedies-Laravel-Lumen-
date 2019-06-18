<?php

namespace App\Http\Controllers;

use App\Remedie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RemedieController extends Controller
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
            'data' => Remedie::with('users')->get(),
            // 'data' => Remedie::with('reviews','users')->get(),
        ]);
    }

    /**
     * Show specific resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
         $validator = validator::make($request->all(),[
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'data' => Remedie::where('type',$request->type)->get()
            ]);
        }
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
            'user_name' => 'required',
            'title' => 'required|unique:remedies',
            'type' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $payload = $request->all();

         if (!empty($request->picture) ) {
            $payload['picture'] = "uploads/remedies/cp_".time().".png";
            $path = base_path('public/'.$payload['picture']);
            file_put_contents($path, base64_decode($request->picture));
        }
        
        $response = Remedie::create($payload);

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
        $response = Remedie::findOrFail($request->id)->update($payload);
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
        $response = Remedie::destroy($request->id);

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
            'data' => Remedie::where($request->key, $request->value)->first()
        ]);
    }
}
