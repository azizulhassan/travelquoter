<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cruise;
use App\Models\Agent;
use App\Models\Client;
use App\Models\CruiseAgent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CruiseController extends Controller
{
    public function index()
    {
        return response([
            'cruises' => Cruise::where('status', true)->get()
        ], 200);
    }

    public function show($id)
    {
        $crusie = Cruise::find($id);
        if ($crusie) {
            return response([
                'crusie' => $crusie
            ], 200);
        }
        return response([
            'exception' => 'Crusie not found'
        ], 404);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',

            'departure_port' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'length_of_cruise' => 'required|string|max:255',
            'any_month_from' => 'required',
            'any_month_to' => 'required',
            'no_of_travelers' => 'required|string|max:255',
            'additional_info' => 'required|string|max:255',

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

        $cruise = Cruise::create([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'agent_id' => $request->agent_id,
            'departure_port' => $request->departure_port,
            'destination' => $request->destination,
            'length_of_cruise' => $request->length_of_cruise,
            'any_month_from' => $request->any_month_from,
            'any_month_to' => $request->any_month_to,
            'no_of_travelers' => $request->no_of_travelers,
            'additional_info' => $request->additional_info,
            'photo' => $request->photo,
            'planner' => $request->planner,
            'extra_field' => $request->extra_field,
            'status' => true
        ]);

        return response([
            'cruise' => $cruise
        ], 200);
    }


    public function cruiseAgent(Request $request) {
        $validator = Validator::make($request->all(), [
            'cruise_id' => 'required|integer',
            'agents' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->cruise_id) {
            $checkCruise = Cruise::find($request->cruise_id);

            if (!$checkCruise) {
                return response([
                    'errors' => [
                        'cruise' => 'Cruise not found'
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

                CruiseAgent::create([
                    'cruise_id' => $request->cruise_id,
                    'agent_id' => $agent_id
                ]);
            }
        }

        return response([
            'message' => 'Data saved successfully'
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
            'Cruise_type' => 'nullable|string|max:255',
            'pick_up_location' => 'nullable|string|max:255',
            'drop_off_location' => 'nullable|string|max:255',
            'pick_up_datetime' => 'nullable',
            'drop_off_datetime' => 'nullable',
            'no_of_travelers' => 'nullable|string|max:255',
            'no_of_Cruises' => 'nullable|string|max:255',
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

        $cruise = Cruise::find($id);

        if (!$cruise) {
            return response([
                'exception' => 'Cruise not found'
            ], 404);
        }

        $cruise->user_id = isset($request->user_id) ? $request->user_id : $cruise->user_id ;
        $cruise->client_id = isset($request->client_id) ? $request->client_id : $cruise->client_id ;
        $cruise->agent_id = isset($request->agent_id) ? $request->agent_id : $cruise->agent_id ;
        $cruise->departure_port = isset($request->departure_port) ? $request->departure_port : $cruise->departure_port ;
        $cruise->destination = isset($request->destination) ? $request->destination : $cruise->destination ;
        $cruise->length_of_cruise = isset($request->length_of_cruise) ? $request->length_of_cruise : $cruise->length_of_cruise ;
        $cruise->any_month_from = isset($request->any_month_from) ? $request->any_month_from : $cruise->any_month_from ;
        $cruise->any_month_to = isset($request->any_month_to) ? $request->any_month_to : $cruise->any_month_to ;
        $cruise->no_of_travelers = isset($request->no_of_travelers) ? $request->no_of_travelers : $cruise->no_of_travelers ;
        $cruise->additional_info = isset($request->additional_info) ? $request->additional_info : $cruise->additional_info ;
        $cruise->photo = isset($request->photo) ? $request->photo : $cruise->photo ;
        $cruise->planner = isset($request->planner) ? $request->planner : $cruise->planner ;
        $cruise->extra_field = isset($request->extra_field) ? $request->extra_field : $cruise->extra_field ;

        return response([
            'Cruise' => $cruise
        ], 200);
    }


    public function search(Request $request)
    {
        $query = Cruise::query();

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

    public function destroy($id)
    {
        $data = Cruise::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }

        return response([
            'exeception' => 'Cruse not found'
        ], 404);
    }
}
