<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AgentResource;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\AgentForgotPasswordMail;
use App\Mail\AgentVerificationMail;
use App\Models\Agency;
use App\Models\FlightAgent;
use App\Models\CarAgent;
use App\Models\HotelAgent;
use App\Models\InsuranceAgent;
use App\Models\VisaAgent;
use App\Models\CruiseAgent;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AgentController extends Controller {

    public function index(Request $request) {

        $vStatus = 1;
        if ($request->has('status') && ($request->status == 0 || $request->status == 1)) {
            $vStatus = $request->status;
        }
        return response([
            'agents' => Agency::with(['agent'])->where('status', $vStatus)->orderBy('created_at', 'DESC')->paginate(20)
                ], 200);
    }

    public function filter(Request $request) {
        $agents = Agency::with('agent')->where('status', true);

        if ($request->has('search')) {
            $search = $request->search;
            $agents = $agents->whereHas('state', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })->orWhere('postcode', 'like', '%' . $search . '%')->orWhere('street_address', 'like', '%' . $search . '%');
        }

        if ($request->has('location')) {
            $location = $request->location;

            if ($location == 'all') {
                
            } else if ($location == 'Australia') {
                $country_id = Country::where('name', $location)->first()->id ?? NULL;
                if ($country_id) {
                    $agents = $agents->where('country_id', $country_id);
                }
            } else if ($location == 'International') {
                
            } else {
                $agents = $agents->where('country_id', (int) $location);
            }
        }

        if ($request->has('top_agents')) {
            if ($request->top_agents) {
                
            }
        }

        if ($request->has('sorting')) {
            if ($request->sorting == 'ASC') {
                $agents = $agents->orderBy('created_at', 'ASC')->get();
            } else {
                $agents = $agents->orderBy('created_at', 'DESC')->get();
            }
        } else {
            $agents = $agents->orderBy('created_at', 'DESC')->get();
        }

        return response([
            'data' => $agents
                ], 200);
    }

    public function show($id) {
        $agent = Agent::with(['offers'])->find($id);

        if ($agent) {
            return response([
                'agent' => new AgentResource($agent)
                    ], 200);
        }

        return response([
            'exception' => 'Agent record not found.'
                ], 404);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'nullable|string|max:255',
                    'contact_number' => 'nullable|string:255',
                    'email' => 'required|email|unique:agents,email|max:255',
                    'password' => 'required|string|confirmed|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::create([
                    'name' => $request->name,
                    'contact_number' => $request->contact_number,
                    'email' => $request->email,
                    'token' => Str::random(100),
                    'password' => Hash::make($request->password),
                    'verification_code' => rand(1000, 9999),
                    'status' => true
        ]);

        $agency = Agency::create([
                    'agent_id' => $agent->id
        ]);

        Mail::to($agent->email)->send(new AgentVerificationMail($agent));

        return response([
            'message' => 'Account created successfully. Please verify your email first.'
                ], 200);
    }

    public function googleLogin(Request $request) {
        $validator = Validator::make($request->all(), [
                    'profile_picture' => 'required|max:255',
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255',
                    'token' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $checkToken = Agent::with(['offers', 'quotes'])->where('token', $request->token)->first();

        if (!$checkToken) {
            $agent = Agent::create([
                        'profile_picture' => $request->profile_pircture,
                        'name' => $request->name,
                        'email' => $request->email,
                        'token' => $request->token,
                        'password' => Hash::make($request->token),
                        'verification_code' => NULL,
                        'status' => true
            ]);

            $agency = Agency::create([
                        'agent_id' => $agent->id
            ]);

            return response([
                'message' => 'Account created successfully.',
                'agent' => new AgentResource($agent)
                    ], 200);
        } else {
            return response([
                'message' => 'Account Found.',
                'agent' => new AgentResource($checkToken)
                    ], 200);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'cover' => 'nullable|image|max:1024',
                    'profile_picture' => 'nullable|image|max:1024',
                    'profession' => 'nullable|string:255',
                    'name' => 'nullable|string|max:255',
                    'contact_number' => 'nullable|string:255',
                    // Agency Part
                    'agency_name' => 'nullable|string|max:255',
                    'mobile_number' => 'nullable',
                    'abn_acn' => 'nullable',
                    'website_url' => 'nullable|url|max:255',
                    'do_you_operate_outside_australia' => 'nullable|boolean',
                    'do_you_sale_through_your_website' => 'nullable|boolean',
                    'business_description' => 'nullable|string',
                    'country_id' => 'nullable|integer',
                    'state_id' => 'nullable|integer',
                    'services' => 'nullable|array',
                    'street_address' => 'nullable|string|max:255',
                    'postcode' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::find($id);

        if ($agent) {
            if ($request->cover != NULL) {
                $image = $request->file('cover');
                $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('/', $filename);
                $imageUrl = $filename;
                $agent->cover = $imageUrl;
            }

            if ($request->profile_picture != NULL) {
                $image = $request->file('profile_picture');
                $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('/', $filename);
                $imageUrl = $filename;
                $agent->cover = $imageUrl;
            }


            $agent->name = isset($request->name) ? $request->name : $agent->name;
            $agent->profession = isset($request->profession) ? $request->profession : $agent->profession;
            $agent->contact_number = isset($request->contact_number) ? $request->contact_number : $agent->contact_number;
            $agent->save();

            $agency = Agency::with(['offers'])->where('agent_id', $agent->id)->first();

            if (!$agency) {
                $agency = Agency::create([
                            'agent_id' => $agent->id
                ]);
            }

            if ($agency) {
                $agency->agency_name = isset($request->agency_name) ? $request->agency_name : $agency->agency_name;
                $agency->mobile_number = isset($request->mobile_number) ? $request->mobile_number : $agency->mobile_number;
                $agency->abn_acn = isset($request->abn_acn) ? $request->abn_acn : $agency->abn_acn;
                $agency->website_url = isset($request->website_url) ? $request->website_url : $agency->website_url;
                $agency->do_you_operate_outside_australia = isset($request->do_you_operate_outside_australia) ? $request->do_you_operate_outside_australia : $agency->do_you_operate_outside_australia;
                $agency->do_you_sale_through_your_website = isset($request->do_you_sale_through_your_website) ? $request->do_you_sale_through_your_website : $agency->do_you_sale_through_your_website;
                $agency->country_id = isset($request->country_id) ? $request->country_id : $agency->country_id;
                $agency->state_id = isset($request->state_id) ? $request->state_id : $agency->state_id;
                $agency->services = isset($request->services) ? $request->services : $agency->services;
                $agency->street_address = isset($request->street_address) ? $request->street_address : $agency->street_address;
                $agency->postcode = isset($request->postcode) ? $request->postcode : $agency->postcode;
                $agency->save();
            }

            return response([
                'agent' => new AgentResource($agent)
                    ], 200);
        }



        return response([
            'exception' => 'Agent not found'
                ], 404);
    }

    public function changepassword(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'old_password' => 'required|string|max:255',
                    'password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::find($id);

        if ($agent) {
            if (!Hash::check($request->old_password, $agent->password)) {
                return response([
                    'errors' => [
                        'old_password' => 'Incorrect old password'
                    ]
                        ], 404);
            }

            $agent->password = isset($request->password) ? Hash::make($request->password) : $agent->password;
            $agent->save();

            return response([
                'agent' => $agent
                    ], 200);
        }
        return response([
            'exception' => 'Agent not found'
                ], 404);
    }

    public function search(Request $request) {
        $query = Agent::with(['offers'])->query();

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

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:255',
                    'password' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::with(['offers'])->where('email', $request->email)->first();

        if ($agent) {
            if ($agent->email_verified_at == NULL) {
                return response([
                    'errors' => [
                        'email' => 'Your accont is not verified'
                    ]
                ]);
            }

            if (!$agent || !Hash::check($request->password, $agent->password)) {
                return response([
                    'message' => 'Incorrect email address or password.'
                        ], 404);
            }

            return response([
                'agent' => new AgentResource($agent),
                    ], 200);
        }
        return response([
            'exception' => 'Agent with this email address is not found. Please register first.'
                ], 404);
    }

    public function resendVerificationMail(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::with(['offers'])->where('email', $request->email)->first();

        if ($agent) {
            if ($agent->verification_code == NULL && $agent->status == true) {
                return response([
                    'errors' => [
                        'email' => 'The email is already verified.'
                    ]
                        ], 404);
            }
            $agent->verification_code = rand(1000, 9999);
            $agent->save();
            Mail::to($agent->email)->send(new AgentVerificationMail($agent));
            return response([
                'message' => 'Verification email has been sent'
                    ], 200);
        }
        return response([
            'exception' => 'Agent with this email address is not found. Please register first.'
                ], 404);
    }

    public function forgotPassword(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::with(['offers'])->where('email', $request->email)->first();

        if ($agent) {
            $agent->verification_code = rand(1000, 9999);
            $agent->save();
            Mail::to($agent->email)->send(new AgentForgotPasswordMail($agent));
            return response([
                'message' => 'Verification email has been sent'
            ]);
        }
        return response([
            'errors' => [
                'email' => 'Agent with this email address is not found. Please register first.'
            ]
                ], 404);
    }

    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:255',
                    'verification_code' => 'required|max:6',
                    'password' => 'required|string|confirmed|max:255',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::with(['offers'])->where('email', $request->email)->first();
        if ($agent) {
            if ($agent->verification_code != $request->verification_code) {
                return response([
                    'errors' => [
                        'verification_code' => 'Invalid verification code'
                    ]
                        ], 404);
            }

            $agent->password = isset($request->password) ? Hash::make($request->password) : $agent->password;

            $agent->verification_code = NULL;

            $agent->save();

            return response([
                'message' => 'Password successfully changed',
                'agent' => new AgentResource($agent)
                    ], 200);
        }
        return response([
            'errors' => [
                'email' => 'Agent with this email address is not found.'
            ]
                ], 404);
    }

    public function verifyMail(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => 'required|email|string:255',
                    'verification_code' => 'required|max:6',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $agent = Agent::with(['offers'])->where('email', $request->email)->where('verification_code', $request->verification_code)->first();

        if ($agent) {
            $agent->email_verified_at = Carbon::now();
            $agent->verification_code = NULL;
            $agent->status = true;
            $agent->save();

            return response([
                'message' => 'Email verified successfully',
                'agent' => new AgentResource($agent)
                    ], 200);
        }

        return response([
            'errors' => [
                'email' => 'Incorrect verification code or email. Please try again with correct verification code and email.'
            ]
                ], 404);
    }

    public function destroy($id) {
        $data = Agent::with(['offers'])->find($id);

        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => new AgentResource($data)
                    ], 200);
        }
        return response([
            'exception' => 'Agent record not found.'
                ], 404);
    }

    public function fAddMultipleAgentServices(Request $request) {

        $validator = Validator::make($request->all(), [
                    'agents' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if (isset($request->flight_id)) {
            $validator = Validator::make($request->all(), [
                        'flight_id' => 'required|integer|exists:flights,id',
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }
        }
        if (isset($request->car_id)) {
            $validator = Validator::make($request->all(), [
                        'car_id' => 'required|integer|exists:cars,id',
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }
        }
        if (isset($request->hotel_id)) {
            $validator = Validator::make($request->all(), [
                        'hotel_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }
        }
        if (isset($request->cruise_id)) {
            $validator = Validator::make($request->all(), [
                        'cruise_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }
        }
        if (isset($request->insurance_id)) {
            $validator = Validator::make($request->all(), [
                        'insurance_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }
        }
        if (isset($request->visa_id)) {
            $validator = Validator::make($request->all(), [
                        'visa_id' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response($validator->errors(), 404);
            }
        }

        if (count($request->agents) > 0) {
            foreach ($request->agents as $agent_id) {
                if (isset($request->flight_id)) {
                    FlightAgent::create([
                        'flight_id' => $request->flight_id,
                        'agent_id' => $agent_id
                    ]);
                }
                if (isset($request->car_id)) {
                    CarAgent::create([
                        'car_id' => $request->car_id,
                        'agent_id' => $agent_id
                    ]);
                }
                if (isset($request->hotel_id)) {
                    HotelAgent::create([
                        'hotel_id' => $request->hotel_id,
                        'agent_id' => $agent_id
                    ]);
                }
                if (isset($request->cruise_id)) {
                    CruiseAgent::create([
                        'cruise_id' => $request->cruise_id,
                        'agent_id' => $agent_id
                    ]);
                }
                if (isset($request->insurance_id)) {
                    InsuranceAgent::create([
                        'insurance_id' => $request->insurance_id,
                        'agent_id' => $agent_id
                    ]);
                }
                if (isset($request->insurance_id)) {
                    VisaAgent::create([
                        'visa_id' => $request->visa_id,
                        'agent_id' => $agent_id
                    ]);
                }
            }
        }



        return response([
            'message' => 'Data saved successfully'
                ], 200);
    }
}
