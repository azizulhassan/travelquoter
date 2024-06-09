<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccommodationType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccommodationTypeController extends Controller
{
    public function index() {
        return response([
            'accommodation-types' => AccommodationType::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }

    public function show($id) {
        $accommodationType = AccommodationType::find($id);

        if ($accommodationType) {
            return response([
                'accommodation-type' => $accommodationType,
            ], 200);
        }
        
        return response([
            'exception' => 'Accommodation type not found'    
        ], 404);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:accommodation_types,slug|max:255',
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
        
        $accommodationType = AccommodationType::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status ?? true
        ]);

        return response([
            'accommodation-type' => $accommodationType
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

        $accommodationType = AccommodationType::find($id);

        if ($accommodationType) {
            $accommodationType->user_id = isset($request->user_id) ? $request->user_id : $accommodationType->user_id;
            $accommodationType->name = isset($request->name) ? $request->name : $accommodationType->name;
            $accommodationType->status = isset($request->status) ? $request->status : $accommodationType->status;

            $accommodationType->save();
    
            return response([
                'accommodation-type' => $accommodationType
            ], 200);
        }
        
        return response([
            'exception' => 'Accommodation Type not found'    
        ], 404);
    }

    public function search(Request $request) {
        $query = AccommodationType::query();

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
        $data = AccommodationType::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        return response([
            'exception' => 'Accommodation type not found'    
        ], 404);
    }
}
