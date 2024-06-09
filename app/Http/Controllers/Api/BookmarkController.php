<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookmarkResource;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookmarkController extends Controller
{
    public function agentBookmarks($agent_id) {
        $data = Bookmark::with(['client', 'agent'])->where('agent_id', $agent_id)->orderBy('created_at', 'DESC')->get();
        return response([
            'data' => BookmarkResource::collection($data)
        ], 200);
    }

    public function clientBookmarks($client_id) {
        $data = Bookmark::with(['client', 'agent'])->where('client_id', $client_id)->orderBy('created_at', 'DESC')->get();
        return response([
            'data' => BookmarkResource::collection($data)
        ], 200);
    }

    public function storeClient(Request $request) {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'offer_id' => 'required|integer|exists:offers,id',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $data = Bookmark::create([
            'client_id' => $request->client_id,
            'offer_id' => $request->offer_id,
        ]);

        return response([
            'data' => new BookmarkResource($data)
        ], 200);
    }

    public function storeAgent(Request $request) {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|integer|exists:agents,id',
            'offer_id' => 'required|integer|exists:offers,id',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $data = Bookmark::create([
            'agent_id' => $request->agent_id,
            'offer_id' => $request->offer_id,
        ]);

        return response([
            'data' => new BookmarkResource($data)
        ], 200);
    }

    public function removeAgentBookmark($agent_id, $id) {
        $data = Bookmark::where('agent_id', $agent_id)->where('id', $id)->first();
        if ($data) {
            $data->delete();
            return response([
                'data' => new BookmarkResource($data),
                'message' => 'Bookmark successfully removed.'
            ], 200);
        }
        return response([
            'exception' => 'Bookmark not found'
        ], 404);
    }

    public function removeClientBookmark($client_id, $id) {
        $data = Bookmark::where('client_id', $client_id)->where('id', $id)->first();
        if ($data) {
            $data->delete();
            return response([
                'data' => new BookmarkResource($data),
                'message' => 'Bookmark successfully removed.'
            ], 200);
        }
        return response([
            'exception' => 'Bookmark not found'
        ], 404);
    }
}
