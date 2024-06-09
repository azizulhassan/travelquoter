<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index() {
        return response([
            'airlines' => Airline::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
