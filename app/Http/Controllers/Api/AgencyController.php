<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Agency;
use App\Models\Agent;
use App\Models\Bookmark;
use App\Models\Country;
use App\Models\State;

class AgencyController extends Controller
{
    public function index() {
        return response([
            'agencies' => Agency::where('status', true)->orderBy('agency_name', 'ASC')->paginate(20),
        ], 200);
    }

    public function show($id) {
        $agency = Agency::find($id);
        if ($agency) {
            return response([
                'agency' => $agency,
            ], 200);
        }
        
        return response([
            'exception' => 'Agency not found'    
        ], 404);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|integer',
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

        $checkCountry = Country::find($request->country_id);

        if (!$checkCountry) {
            return response([
                'country' => 'Country id not found'
            ], 404);
        }

        $checkState = State::find($request->state_id);

        if (!$checkState) {
            return response([
                'state' => 'State id not found'
            ], 404);
        }

        $checkAgent = Agent::find($request->agent_id);

        if (!$checkAgent) {
            return response([
                'agent' => 'Agent id not found'
            ], 404);
        }
        
        $checkAgency = Agency::where('agent_id', $request->agent_id)->first();
        
        if ($checkAgency) {
            return response([
                'exception' => 'There is already agency record for this agent. Please use that record.',
                'agency' => $checkAgency
            ], 404);
        }
        
        try {
            $agency = Agency::create([
                'agent_id' => $request->agent_id,
                'agency_name' => $request->agency_name,
                'mobile_number' => $request->mobile_number,
                'abn_acn' => $request->abn_acn,
                'website_url' => $request->website_url,
                'do_you_operate_outside_australia' => $request->do_you_operate_outside_australia,
                'do_you_sale_through_your_website' => $request->do_you_sale_through_your_website,
                'business_description' => $request->business_description,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'services' => $request->services,
                'street_address' => $request->street_address,
                'postcode' => $request->postcode,
                'status' => true
            ]);
    
            return response([
                'agency' => $agency
            ], 200);
        } catch(\Illuminate\Database\QueryException $e) {
            return response([
                'exception' => 'There is a conflict with the foreign key constraint. Try again with different agent id.'    
            ], 404);
        }
    }


    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
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
        
        $agency = Agency::find($id);
        
        if ($agency) {
            $agency->agency_name = isset($request->agency_name) ? $request->agency_name : $agency->agency_name ;
            $agency->mobile_number = isset($request->mobile_number) ? $request->mobile_number : $agency->mobile_number ;
            $agency->abn_acn = isset($request->abn_acn) ? $request->abn_acn : $agency->abn_acn ;
            $agency->website_url = isset($request->website_url) ? $request->website_url : $agency->website_url ;
            $agency->do_you_operate_outside_australia = isset($request->do_you_operate_outside_australia) ? $request->do_you_operate_outside_australia : $agency->do_you_operate_outside_australia ;
            $agency->do_you_sale_through_your_website = isset($request->do_you_sale_through_your_website) ? $request->do_you_sale_through_your_website : $agency->do_you_sale_through_your_website ;
            $agency->country_id = isset($request->country_id) ? $request->country_id : $agency->country_id ;
            $agency->state_id = isset($request->state_id) ? $request->state_id : $agency->state_id ;
            $agency->services = isset($request->services) ? $request->services : $agency->services ;
            $agency->street_address = isset($request->street_address) ? $request->street_address : $agency->street_address ;
            $agency->postcode = isset($request->postcode) ? $request->postcode : $agency->postcode ;
    
            $agency->save();
    
            return response([
                'agency' => $agency
            ], 200);
        }
        
        return response([
            'exception' => 'Agency not found'    
        ], 404);
    }

    public function search(Request $request) {
        $query = State::has('agencies')->with(['agencies', 'country'])->where('status', true);

        $query = $query->where(function ($query) use ($request) {
            if ($request->search) {
                $search = $request->search;
                $query->whereHas('country', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })->orWhere('name', 'like', '%' . $search . '%');
            }

            if ($request->location) {
                $countryArray = Country::pluck('id');
                if ($request->location == "All") {
                    $query = $query->whereIn('country_id', $countryArray);
                } elseif ($request->location == "International") {
                    $query = $query->where('country_id', '!=', $request->australia_id)->whereIn('country_id', $countryArray);
                } else {
                    $query = $query->where('country_id', $request->australia_id);
                }
            }

            if ($request->country) {
                $query->where('country_id', $request->country);
            }

            if ($request->category) {
                if ($request->category == 'Recent') {
                    $query = $query->orderBy('created_at', 'DESC');
                } elseif ($request->category == 'Top') {
                    $query = $query->orderBy('created_at', 'ASC');
                } elseif ($request->category == 'Random') {
                    $query = $query->orderBy('created_at', 'DESC');
                } else {
                    if ($request->category == 'Bookmarked') {
                        if ($request->client_id) {
                            $bookmarks = Bookmark::where('client_id', $request->client_id)->pluck('agent_id');
                            $query = $query->whereHas('agencies', function ($query) use ($bookmarks) {
                                return $query->whereIn('agent_id', $bookmarks);
                            });
                        }
                    }
                }
            }
        });

        $query = $query->get();

        $agents_array = $query->map(function ($item) {
            return [
                'location' => $item->name . ', ' . $item->country->name,
                'agents' => $item->agencies->toArray()
            ];
        });


        return response([
            'search' => $agents_array
        ], 200);
    }

    public function destroy($id)
    {
        $data = Agency::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        return response([
            'exception' => 'Agency not found'    
        ], 404);
    }
}
