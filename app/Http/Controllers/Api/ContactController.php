<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'enquiry_type' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|max:1000'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $contact = Contact::create([
            'enquiry_type' => $request->enquiry_type,
            'full_name' => $request->full_name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'message' => $request->message,
            'status' => true
        ]);

        return response([
            'contact' => $contact
        ], 200);
    }
}
