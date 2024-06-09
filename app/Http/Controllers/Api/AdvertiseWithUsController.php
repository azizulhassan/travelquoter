<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdvertiseWithUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertiseWithUsController extends Controller
{
    public function index()
    {
        return response([
            'advertise_with_us' => AdvertiseWithUs::orderBy('created_at', 'DESC')->get()
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_detail' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $advertise_with_us = AdvertiseWithUs::create([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'company_detail' => $request->company_detail,
            'status' => false
        ]);

        return response([
            'advertise_with_us' => $advertise_with_us
        ], 200);
    }

    public function destroy($id)
    {
        $data = AdvertiseWithUs::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'Advertise with us details not found'
        ], 404);
    }
}
