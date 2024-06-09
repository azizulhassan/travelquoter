<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\ClientForgotPasswordMail;
use App\Mail\ClientVerificationMail;
use App\Models\Client;
use App\Models\Country;
use App\Models\Quote;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index()
    {
        return response([
            'clients' => Client::where('status', true)->orderBy('created_at', 'DESC')->paginate(20)
        ], 200);
    }

    public function show($id)
    {
        $client = Client::find($id);

        if ($client) {
            return response([
                'client' => Client::find($id)
            ], 200);
        }
        return response([
            'exception' => 'Client record not found.'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'email' => 'required|email|unique:clients,email|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::create([
            'name' => $request->name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'token' => Str::random(100),
            'password' => Hash::make($request->password),
            'verification_code' => rand(1000, 9999),
            'status' => true
        ]);


        // Send Verification Mail
        Mail::to($client->email)->send(new ClientVerificationMail($client));

        return response([
            'message' => 'Account created successfully. Please verify your email first.'
        ], 200);
    }

    public function googleLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'token' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $checkToken = Client::where('token', $request->token)->first();

        if (!$checkToken) {
            $client = Client::create([
                'profile_picture' => $request->profile_pircture,
                'name' => $request->name,
                'email' => $request->email,
                'token' => $request->token,
                'password' => Hash::make($request->token),
                'verification_code' => NULL,
                'status' => true
            ]);

            return response([
                'message' => 'Account created successfully.',
                'client' => $client,
                'quotes' => Quote::where('email', $client->email)->get()
            ], 200);
        } else {
            return response([
                'message' => 'Account Found.',
                'client' => $checkToken,
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::find($id);

        if ($client) {

            if ($request->country_id) {
                $checkCountry = Country::find($request->country_id);
                
                if (!$checkCountry) {
                    return response([
                        'country' => 'Country id not found'
                    ], 404);
                }
            }
    
            if ($request->state_id) {
                $checkState = State::find($request->state_id);
        
                if (!$checkState) {
                    return response([
                        'state' => 'State id not found'
                    ], 404);
                }
            }


            if ($request->cover != NULL) {
                $image = $request->file('cover');
                $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public', $filename);
                $imageUrl = 'storage/' . $filename;

                $client->cover = $imageUrl;
            }

            if ($request->profile_picture != NULL) {
                $image = $request->file('profile_picture');
                $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public', $filename);
                $imageUrl = 'storage/' . $filename;

                $client->profile_picture = $imageUrl;
            }


            $client->name = isset($request->name) ? $request->name : $client->name;
            $client->profession = isset($request->profession) ? $request->profession : $client->profession;
            $client->contact_number = isset($request->contact_number) ? $request->contact_number : $client->contact_number;

            $client->country_id = isset($request->country_id) ? $request->country_id : $client->country_id ;
            $client->state_id = isset($request->state_id) ? $request->state_id : $client->state_id ;
            $client->street_address = isset($request->street_address) ? $request->street_address : $client->street_address ;
            $client->postcode = isset($request->postcode) ? $request->postcode : $client->postcode ;

            $client->save();

            return response([
                'client' => $client,
                'quotes' => Quote::where('email', $client->email)->get()
            ], 200);
        }
        return response([
            'exception' => 'Client not found'
        ], 404);
    }

    public function changepassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::find($id);
        if ($client) {
            if (!Hash::check($request->old_password, $client->password)) {
                return response([
                    'errors' => [
                        'old_password' => 'Incorrect old password'
                    ]
                ], 404);
            }

            $client->password = isset($request->password) ? Hash::make($request->password) : $client->password;
            $client->save();

            return response([
                'client' => $client
            ], 200);
        }
        return response([
            'exception' => 'Client not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = Client::query();

        if ($request->search) {
            $query = $query->where('name', 'like', '%' . $request->search . '%')->orWhere('contact_number', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('name', 'ASC')->get();
            } else {
                $query = $query->orderBy('name', 'ASC')->get();
            }
        } else {
            $query = $query->orderBy('name', 'DESC')->get();
        }

        return response([
            'search' => $query
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::where('email', $request->email)->first();
        if ($client) {
            if ($client->email_verified_at == NULL) {
                return response([
                    'errors' => [
                        'email' => 'Your accont is not verified'
                    ]
                ]);
            }

            if (!$client || !Hash::check($request->password, $client->password)) {
                return response([
                    'message' => 'Incorrect email address or password.'
                ], 404);
            }

            return response([
                'client' => $client,
                'quotes' => Quote::where('email', $client->email)->get()
            ], 200);
        }
        return response([
            'exception' => 'Client with this email address is not found. Please register first.'
        ], 404);
    }

    public function resendVerificationMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::where('email', $request->email)->first();

        if ($client) {
            if ($client->verification_code == NULL && $client->status == true) {
                return response([
                    'errors' => [
                        'email' => 'The email is already verified.'
                    ]
                ], 404);
            }
            $client->verification_code = rand(1000, 9999);
            $client->save();
            // Send Verification Mail
            Mail::to($client->email)->send(new ClientVerificationMail($client));
            return response([
                'message' => 'Verification email has been sent'
            ]);
        }
        return response([
            'exception' => 'Client with this email address is not found. Please register first.'
        ], 404);
    }

    public function verifyMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string:255',
            'verification_code' => 'required|max:6',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::where('email', $request->email)->where('verification_code', $request->verification_code)->first();

        if ($client) {
            $client->email_verified_at = Carbon::now();
            $client->verification_code = NULL;
            $client->status = true;
            $client->save();

            return response([
                'message' => 'Email verified successfully',
                'client' => $client
            ], 200);
        }

        return response([
            'errors' => [
                'email' => 'Incorrect verification code or email. Please try again with correct verification code and email.'
            ]
        ], 404);
    }


    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::where('email', $request->email)->first();

        if ($client) {
            $client->verification_code = rand(1000, 9999);
            $client->save();
            // Send Verification Mail
            Mail::to($client->email)->send(new ClientForgotPasswordMail($client));
            return response([
                'message' => 'Verification email has been sent'
            ]);
        }
        return response([
            'errors' => [
                'email' => 'Email address does not exists.'
            ]
        ], 404);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'verification_code' => 'required|max:6',
            'password' => 'required|string|confirmed|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $client = Client::where('email', $request->email)->first();

        if ($client) {
            if ($client->verification_code != $request->verification_code) {
                return response([
                    'errors' => [
                        'verification_code' => 'Invalid verification code'
                    ]
                ], 404);
            }

            $client->password = isset($request->password) ? Hash::make($request->password) : $client->password;

            $client->verification_code = NULL;

            $client->save();

            return response([
                'message' => 'Password successfully changed',
                'client' => $client
            ], 200);
        }
        return response([
            'errors' => [
                'email' => 'Client with this email address is not found.'
            ]
        ], 404);
    }


    public function destroy($id)
    {
        $data = Client::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        return response([
            'exception' => 'Client does not exists'
        ], 404);
    }
}
