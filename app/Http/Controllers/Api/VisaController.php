<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PassportType;
use App\Models\Visa;
use App\Models\VisitPurpose;
use App\Models\Agent;
use App\Models\Client;
use App\Models\User;
use App\Models\VisaAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisaController extends Controller {

    public function index() {
        return response([
            'visa' => Visa::where('status', true)->get()
                ], 200);
    }

    public function show($id) {
        $visa = Visa::find($id);
        if ($visa) {
            return response([
                'visa' => $visa
                    ], 200);
        }
        return response([
            'exception' => 'Visa not found'
                ], 404);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'nullable|integer',
                    'client_id' => 'nullable|integer',
                    'agent_id' => 'nullable|integer',
                    'country_of_passport' => 'required|string|max:255',
                    'passport_type_id' => 'required|integer',
                    'pick_up_date' => 'required|date',
                    'drop_off_date' => 'required|date',
                    'no_of_travelers' => 'required|string|max:255',
                    'visit_purpose_id' => 'required|integer|max:255',
                    'no_of_visit' => 'required|string|max:255',
                    'photo' => 'nullable|json',
                    'planner' => 'nullable|json',
                    'extra_field' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->user_id) {
            $checkUser = User::find($request->user_id);

            if (!$checkUser) {
                return response([
                    'errors' => [
                        'user' => 'User not found'
                    ]
                        ], 404);
            }
        }

        if ($request->agent_id) {
            $checkAgent = Agent::find($request->agent_id);

            if (!$checkAgent) {
                return response([
                    'errors' => [
                        'agent' => 'Agent not found'
                    ]
                        ], 404);
            }
        }

        if ($request->client_id) {
            $checkClient = Client::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'errors' => [
                        'client' => 'Client not found'
                    ]
                        ], 404);
            }
        }

        if ($request->passport_type_id) {
            $checkClient = PassportType::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'errors' => [
                        'passport_type' => 'Passport type not found'
                    ]
                        ], 404);
            }
        }

        if ($request->visit_purpose_id) {
            $checkClient = VisitPurpose::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'errors' => [
                        'visit_purpose' => 'Visit purpose not found'
                    ]
                        ], 404);
            }
        }

        $visa = Visa::create([
                    'user_id' => $request->user_id,
                    'client_id' => $request->client_id,
                    'agent_id' => $request->agent_id,
                    'country_of_passport' => $request->country_of_passport,
                    'passport_type_id' => $request->passport_type_id,
                    'pick_up_date' => $request->pick_up_date,
                    'drop_off_date' => $request->drop_off_date,
                    'no_of_travelers' => $request->no_of_travelers,
                    'visit_purpose_id' => $request->visit_purpose_id,
                    'no_of_visit' => $request->no_of_visit,
                    'photo' => $request->photo,
                    'planner' => $request->planner,
                    'extra_field' => $request->extra_field,
                    'status' => true
        ]);

        return response([
            'visa' => $visa
                ], 200);
    }

    public function search(Request $request) {
        $query = Visa::query();

        if ($request->search) {
            $query = $query->where('id', $request->id);
        }

        if ($request->sorting) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('created_at', 'ASC')->get();
            } else {
                $query = $query->orderBy('created_at', 'ASC')->get();
            }
        } else {
            $query = $query->orderBy('created_at', 'DESC')->get();
        }

        return response([
            'search' => $query
                ], 200);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'nullable|integer',
                    'client_id' => 'nullable|integer',
                    'agent_id' => 'nullable|integer',
                    'country_of_passport' => 'nullable|string|max:255',
                    'passport_type_id' => 'nullable|integer',
                    'pick_up_date' => 'nullable|date',
                    'drop_off_date' => 'nullable|date',
                    'no_of_travelers' => 'nullable|string|max:255',
                    'visit_purpose_id' => 'nullable|integer|max:255',
                    'no_of_visit' => 'nullable|string|max:255',
                    'photo' => 'nullable|json',
                    'planner' => 'nullable|json',
                    'extra_field' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }
        if ($request->user_id) {
            $checkUser = User::find($request->user_id);

            if (!$checkUser) {
                return response([
                    'errors' => [
                        'user' => 'User not found'
                    ]
                        ], 404);
            }
        }

        if ($request->agent_id) {
            $checkAgent = Agent::find($request->agent_id);

            if (!$checkAgent) {
                return response([
                    'errors' => [
                        'agent' => 'Agent not found'
                    ]
                        ], 404);
            }
        }

        if ($request->client_id) {
            $checkClient = Client::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'errors' => [
                        'client' => 'Client not found'
                    ]
                        ], 404);
            }
        }

        if ($request->agent_id) {
            $checkAgent = Agent::find($request->agent_id);

            if (!$checkAgent) {
                return response([
                    'agent' => 'Agent not found'
                        ], 404);
            }
        }

        if ($request->client_id) {
            $checkClient = Client::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'client' => 'Client not found'
                        ], 404);
            }
        }

        if ($request->passport_type_id) {
            $checkClient = PassportType::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'errors' => [
                        'passport_type' => 'Passport type not found'
                    ]
                        ], 404);
            }
        }

        if ($request->visit_purpose_id) {
            $checkClient = VisitPurpose::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'errors' => [
                        'visit_purpose' => 'Visit purpose not found'
                    ]
                        ], 404);
            }
        }

        $visa = Visa::find($id);

        if (!$visa) {
            return response([
                'exception' => 'Visa not found'
                    ], 404);
        }

        $visa->user_id = isset($request->user_id) ? $request->user_id : $visa->user_id;
        $visa->client_id = isset($request->client_id) ? $request->client_id : $visa->client_id;
        $visa->agent_id = isset($request->agent_id) ? $request->agent_id : $visa->agent_id;
        $visa->country_of_passport = isset($request->country_of_passport) ? $request->country_of_passport : $visa->country_of_passport;
        $visa->passport_type_id = isset($request->passport_type_id) ? $request->passport_type_id : $visa->passport_type_id;
        $visa->pick_up_date = isset($request->pick_up_date) ? $request->pick_up_date : $visa->pick_up_date;
        $visa->drop_off_date = isset($request->drop_off_date) ? $request->drop_off_date : $visa->drop_off_date;
        $visa->no_of_travelers = isset($request->no_of_travelers) ? $request->no_of_travelers : $visa->no_of_travelers;
        $visa->visit_purpose_id = isset($request->visit_purpose_id) ? $request->visit_purpose_id : $visa->visit_purpose_id;
        $visa->no_of_visit = isset($request->no_of_visit) ? $request->no_of_visit : $visa->no_of_visit;
        $visa->photo = isset($request->photo) ? $request->photo : $visa->photo;
        $visa->planner = isset($request->planner) ? $request->planner : $visa->planner;
        $visa->extra_field = isset($request->extra_field) ? $request->extra_field : $visa->extra_field;

        return response([
            'visa' => $visa
                ], 200);
    }

    public function destroy($id) {
        $data = Visa::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
                    ], 200);
        }

        return response([
            'exeception' => 'Visa not found'
                ], 404);
    }

    public function visaAgent(Request $request) {
        $validator = Validator::make($request->all(), [
                    'visa_id' => 'required|integer|exists:visas,id',
                    'agents' => 'required|array',
                    'agents.*' => 'integer|exists:agents,id'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if (count($request->agents) > 0) {
            foreach ($request->agents as $agent_id) {
                VisaAgent::create([
                    'visa_id' => $request->visa_id,
                    'agent_id' => $agent_id
                ]);
            }
        }

        return response([
            'message' => 'Data saved successfully'
                ], 200);
    }
}
