<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisitPurpose;
use Illuminate\Http\Request;

class VisitPurposeController extends Controller
{
    public function index() {
        return response([
            'visit-purposes' => VisitPurpose::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
