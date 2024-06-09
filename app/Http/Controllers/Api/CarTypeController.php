<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    public function index() {
        return response([
            'car-types' => CarType::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
