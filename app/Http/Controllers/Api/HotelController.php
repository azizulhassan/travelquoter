<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Agent;
use App\Models\Client;
use App\Models\HotelAgent;
use App\Models\User;

class HotelController extends Controller
{
    public function index()
    {
        return response([
            'hotels' => Hotel::where('status', true)->get()
        ], 200);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id);
        if ($hotel) {
            return response([
                'hotel' => $hotel
            ], 200);
        }
        return response([
            'exception' => 'Hotel not found'
        ], 404);
    }


    public function hotelAgent(Request $request) {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|integer',
            'agents' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->hotel_id) {
            $checkHotel = Hotel::find($request->hotel_id);

            if (!$checkHotel) {
                return response([
                    'errors' => [
                        'hotel' => 'Hotel not found'
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

                HotelAgent::create([
                    'hotel_id' => $request->hotel_id,
                    'agent_id' => $agent_id
                ]);
            }
        }

        return response([
            'message' => 'Data saved successfully'
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'client_id' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
            'desired_city' => 'required|string|max:255',
            'check_in' => 'required|string|max:255',
            'check_out' => 'required|string|max:255',
            'trip_days' => 'required|integer',
            'no_of_travelers' => 'required|string|max:255',
            'accommodation_type' => 'required|string|max:255',
            'room' => 'required|string|max:255',
            'rating' => 'required|string|max:255',
            'other' => 'required|string|max:255',
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

        $hotel = Hotel::create([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'agent_id' => $request->agent_id,
            'desired_city' => $request->desired_city,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'trip_days' => $request->trip_days,
            'no_of_travelers' => $request->no_of_travelers,
            'accommodation_type' => $request->accommodation_type,
            'room' => $request->room,
            'rating' => $request->rating,
            'other' => $request->other,
            'photo' => $request->photo,
            'planner' => $request->planner,
            'extra_field' => $request->extra_field,
            'status' => true
        ]);

        return response([
            'hotel' => $hotel
        ], 200);
    }


    public function search(Request $request)
    {
        $query = Hotel::query();

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
            'desired_city' => 'nullable|string|max:255',
            'check_in' => 'nullable|string|max:255',
            'check_out' => 'nullable|string|max:255',
            'trip_days' => 'nullable|integer',
            'no_of_travelers' => 'nullable|string|max:255',
            'accommodation_type' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:255',
            'other' => 'nullable|string|max:255',
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

        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response([
                'exception' => 'hotel not found'
            ], 404);
        }

        $hotel->user_id = isset($request->user_id) ? $request->user_id : $hotel->user_id ;
        $hotel->client_id = isset($request->client_id) ? $request->client_id : $hotel->client_id ;
        $hotel->agent_id = isset($request->agent_id) ? $request->agent_id : $hotel->agent_id ;
        $hotel->desired_city = isset($request->desired_city) ? $request->desired_city : $hotel->desired_city ;
        $hotel->check_in = isset($request->check_in) ? $request->check_in : $hotel->check_in ;
        $hotel->check_out = isset($request->check_out) ? $request->check_out : $hotel->check_out ;
        $hotel->trip_days = isset($request->trip_days) ? $request->trip_days : $hotel->trip_days ;
        $hotel->no_of_travelers = isset($request->no_of_travelers) ? $request->no_of_travelers : $hotel->no_of_travelers ;
        $hotel->accommodation_type = isset($request->accommodation_type) ? $request->accommodation_type : $hotel->accommodation_type ;
        $hotel->room = isset($request->room) ? $request->room : $hotel->room ;
        $hotel->rating = isset($request->rating) ? $request->rating : $hotel->rating ;
        $hotel->others = isset($request->others) ? $request->others : $hotel->others ;
        $hotel->photo = isset($request->photo) ? $request->photo : $hotel->photo ;
        $hotel->planner = isset($request->planner) ? $request->planner : $hotel->planner ;
        $hotel->extra_field = isset($request->extra_field) ? $request->extra_field : $hotel->extra_field ;

        return response([
            'hotel' => $hotel
        ], 200);
    }

    public function destroy($id)
    {
        $data = Hotel::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }

        return response([
            'exeception' => 'Hotel not found'
        ], 404);
    }
}
