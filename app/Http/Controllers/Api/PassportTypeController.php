<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PassportType;
use Illuminate\Http\Request;

class PassportTypeController extends Controller
{
    public function index() {
        return response([
            'passport-types' => PassportType::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
