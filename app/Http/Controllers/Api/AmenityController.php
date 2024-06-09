<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmenityController extends Controller
{
    public function index() {
        return response([
            'amenities' => Amenity::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }

    public function show($id) {
        $amenity = Amenity::find($id);

        if ($amenity) {
            return response([
                'amenity' => $amenity,
            ], 200);
        }
        
        return response([
            'amenity' => 'Amenity not found'    
        ], 404);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:amenities,slug|max:255',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $checkUser= User::find($request->user_id);

        if (!$checkUser) {
            return response([
                'user' => 'User id not found'
            ], 404);
        }
        
        $amenity = Amenity::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status ?? true
        ]);

        return response([
            'amenity' => $amenity
        ], 200);
    }


    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
            'status' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $checkUser= User::find($request->user_id);

        if (!$checkUser) {
            return response([
                'user' => 'User id not found'
            ], 404);
        }

        $amenity = Amenity::find($id);

        if ($amenity) {
            $amenity->user_id = isset($request->user_id) ? $request->user_id : $amenity->user_id;
            $amenity->name = isset($request->name) ? $request->name : $amenity->name;
            $amenity->status = isset($request->status) ? $request->status : $amenity->status;

            $amenity->save();
    
            return response([
                'accommodation-type' => $amenity
            ], 200);
        }
        
        return response([
            'exception' => 'Accommodation Type not found'    
        ], 404);
    }

    public function search(Request $request) {
        $query = Amenity::query();

        if ($request->search) {
            $query = $query->where('name', 'like', '%'.$request->search.'%')->where('slug', 'like', '%'.$request->search.'%');
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('name', 'ASC')->get();
            }
            else {
                $query = $query->orderBy('name', 'ASC')->get();
            }
        }
        else {
            $query = $query->orderBy('name', 'DESC')->get();
        }

        return response([
            'search' => $query
        ], 200);
    }

    public function destroy($id)
    {
        $data = Amenity::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        return response([
            'exception' => 'Amenity not found'    
        ], 404);
    }
}
