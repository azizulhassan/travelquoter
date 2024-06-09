<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlightClass;
use Illuminate\Http\Request;

class FlightClassController extends Controller
{
    public function index() {
        return response([
            'flight-classes' => FlightClass::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
