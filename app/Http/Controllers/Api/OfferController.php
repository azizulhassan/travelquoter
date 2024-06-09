<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfferResource;
use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class OfferController extends Controller
{
    public function index()
    {
        $data = Offer::where('status', true)->where('valid_from', '<=', Carbon::now())->orderBy('created_at', 'DESC')->get();
        return response([
            'offers' => OfferResource::collection($data)
        ], 200);
    }

    public function show($id)
    {
        $offer = Offer::find($id);
        if ($offer) {
            return response([
                'offer' => new OfferResource($offer)
            ], 200);
        }
        return response([
            'exception' => 'Quote not found'
        ], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|integer|exists:agents,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'person' => 'required|integer',
            'is_featured' => 'required|boolean',
            'previous_price' => 'required|numeric',
            'current_price' => 'required|numeric',
            'valid_from' => 'required|date',
            'valid_till' => 'required|date',
            'thumbnail' => 'nullable|image|max:1024',
            'description' => 'required',
            'location' => 'required|string',
            'extra_field' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $imageUrl = NULL;

        if ($request->thumbnail != NULL) {
            $image = $request->file('thumbnail');
            $filename = uniqid('offer_thumbnail_', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $filename);
            $imageUrl = 'uploads/' . $filename;
        }

        $offer = Offer::create([
            'agent_id' => $request->agent_id,
            'title' => $request->title,
            'is_featured' => $request->is_featured,
            'short_description' => $request->short_description,
            'previous_price' => $request->previous_price,
            'current_price' => $request->current_price,
            'valid_from' => $request->valid_from,
            'valid_till' => $request->valid_till,
            'thumbnail' => $imageUrl,
            'description' => $request->description,
            'location' => $request->location,
            'person' => $request->person,
            'extra_field' => $request->extra_field,
            'status' => true
        ]);

        return response([
            'offer' => new OfferResource($offer)
        ], 200);
    }

    public function search(Request $request)
    {
        $query = Offer::query();

        if ($request->has('search')) {
            $query = $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query = $query->where('category', $request->category);
        }

        if ($request->has('min_price')) {
            $query = $query->where('current_price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query = $query->where('current_price', '<=', $request->max_price);
        }

        if ($request->is_expired) {
            $query = $query->where('valid_till', '<=', Carbon::now());
        }

        if ($request->has('date_from')) {
            $query = $query->where('valid_from', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query = $query->where('valid_till', '<=', $request->date_to);
        }

        if ($request->has('country_from')) {
            $query = $query->where('location', $request->country_from);
        }

        if ($request->has('country_to')) {
            $query = $query->where('location', $request->country_to);
        }
        
        if ($request->has('sorting')) {
            if ($request->sorting == 'ASC') {
                $query = $query->orderBy('created_at', 'ASC')->get();
            } else {
                $query = $query->orderBy('created_at', 'ASC')->get();
            }
        } else {
            $query = $query->orderBy('created_at', 'DESC')->get();
        }

        return response([
            'offer' => OfferResource::collection($query)
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'previous_price' => 'nullable|numeric',
            'current_price' => 'nullable|numeric',
            'valid_from' => 'nullable|date',
            'valid_till' => 'nullable|date',
            'thumbnail' => 'nullable|image|max:1024',
            'description' => 'nullable',
            'location' => 'nullable|string',
            'extra_field' => 'nullable|array',
            'is_featured' => 'nullable|boolean',
            'short_description' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $imageUrl = NULL;

        if ($request->thumbnail != NULL) {
            $image = $request->file('thumbnail');
            $filename = uniqid('offer_thumbnail_', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public', $filename);
            $imageUrl = 'uploads/' . $filename;
        }


        $offer = Offer::find($id);

        if ($offer) {
            $offer->title = isset($request->title) ? $request->title : $offer->title ;
            $offer->previous_price = isset($request->previous_price) ? $request->previous_price : $offer->previous_price ;
            $offer->current_price = isset($request->current_price) ? $request->current_price : $offer->current_price ;
            $offer->valid_from = isset($request->valid_from) ? $request->valid_from : $offer->valid_from ;
            $offer->valid_till = isset($request->valid_till) ? $request->valid_till : $offer->valid_till ;
            $offer->thumbnail = isset($request->thumbnail) ? $imageUrl : $offer->thumbnail ;
            $offer->description = isset($request->description) ? $request->description : $offer->description ;
            $offer->location = isset($request->location) ? $request->location : $offer->location ;

            $offer->short_description = isset($request->short_description) ? $request->short_description : $offer->short_description ;
            $offer->is_featured = isset($request->is_featured) ? $request->is_featured : $offer->is_featured ;
            $offer->extra_field = isset($request->extra_field) ? $request->extra_field : $offer->extra_field ;
            $offer->save();

            return response([
                'offer' => new OfferResource($offer)
            ], 200);
        }
        return response([
            'exception' => 'Offer not found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = Offer::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Offer deleted',
                'offer' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'Offer not found'
        ], 404);
    }
}
