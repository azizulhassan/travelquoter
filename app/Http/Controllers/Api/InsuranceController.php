<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\Agent;
use App\Models\Client;
use App\Models\InsuranceAgent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
{
    public function index()
    {
        return response([
            'insurances' => Insurance::where('status', true)->get()
        ], 200);
    }

    public function show($id)
    {
        $insurance = Insurance::find($id);
        if ($insurance) {
            return response([
                'insurance' => $insurance
            ], 200);
        }
        return response([
            'exception' => 'Insurance not found'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
            'countries' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'age_of_travelers' => 'required|string|max:255',
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

        $insurance = Insurance::create([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'agent_id' => $request->agent_id,
            'countries' => $request->countries,
            'departure_date' => $request->departure_date,
            'arrival_date' => $request->arrival_date,
            'age_of_travelers' => $request->age_of_travelers,
            'photo' => $request->photo,
            'planner' => $request->planner,
            'extra_field' => $request->extra_field,
            'status' => true
        ]);

        return response([
            'insurance' => $insurance
        ], 200);
    }

    public function insuranceAgent(Request $request) {
        $validator = Validator::make($request->all(), [
            'insurance_id' => 'required|integer',
            'agents' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->insurance_id) {
            $checkInsurance = Insurance::find($request->insurance_id);

            if (!$checkInsurance) {
                return response([
                    'errors' => [
                        'insurance' => 'Insurance not found'
                    ]
                ], 404);
            }
        }

        if (count($request->agents) > 0) {
            foreach($request->agents as $agent_id) {
                $checkAgent = Agent::find($agent_id);
                if (!$checkAgent) {
                    return response([
                        'exception' => 'Agent you have used in an array does\'t exists.'
                    ], 404);
                }

                InsuranceAgent::create([
                    'insurance_id' => $request->insurance_id,
                    'agent_id' => $agent_id
                ]);
            }
        }

        return response([
            'message' => 'Data saved successfully'
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Insurance::query();

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

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
            'countries' => 'nullable|string|max:255',
            'departure_date' => 'nullable|date',
            'arrival_date' => 'nullable|date',
            'age_of_travelers' => 'nullable|string|max:255',
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

        $insurance = Insurance::find($id);

        if (!$insurance) {
            return response([
                'exception' => 'Car not found'
            ], 404);
        }

        $insurance->user_id = isset($request->user_id) ? $request->user_id : $insurance->user_id ;
        $insurance->client_id = isset($request->client_id) ? $request->client_id : $insurance->client_id ;
        $insurance->agent_id = isset($request->agent_id) ? $request->agent_id : $insurance->agent_id ;
        $insurance->countries = isset($request->countries) ? $request->countries : $insurance->countries ;
        $insurance->departure_date = isset($request->departure_date) ? $request->departure_date : $insurance->departure_date ;
        $insurance->arrival_date = isset($request->arrival_date) ? $request->arrival_date : $insurance->arrival_date ;
        $insurance->age_of_travelers = isset($request->age_of_travelers) ? $request->age_of_travelers : $insurance->age_of_travelers ;
        $insurance->photo = isset($request->photo) ? $request->photo : $insurance->photo ;
        $insurance->planner = isset($request->planner) ? $request->planner : $insurance->planner ;
        $insurance->extra_field = isset($request->extra_field) ? $request->extra_field : $insurance->extra_field ;

        return response([
            'insurance' => $insurance
        ], 200);
    }

    public function destroy($id)
    {
        $data = Insurance::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }

        return response([
            'exeception' => 'Insurance not found'
        ], 404);
    }
}
