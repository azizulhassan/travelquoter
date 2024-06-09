<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response([
            'data' => Setting::get()
        ], 200);
    }

    public function show($id)
    {
        $data = Setting::find($id);
        if ($data) {
            return response([
                'data' => $data
            ], 200);
        }
        return response([
            'exception' => 'Data not found'
        ], 404);
    }
}
