<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CruiseAdditionalInfo;
use Illuminate\Http\Request;

class CruiseAdditionalInfoController extends Controller
{
    public function index() {
        return response([
            'cruise additional infos' => CruiseAdditionalInfo::where('status', true)->orderBy('name', 'ASC')->get(),
        ], 200);
    }
}
