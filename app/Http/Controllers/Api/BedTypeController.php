<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BedType;
use Illuminate\Http\Request;

class BedTypeController extends Controller
{
    public function index() {
        return response([
            'bed-types' => BedType::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
