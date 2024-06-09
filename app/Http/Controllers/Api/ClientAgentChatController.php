<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientAgentChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientAgentChatController extends Controller
{
    public function index()
    {
        return response([
            'chats' => ClientAgentChat::where('status', true)->orderBy('created_at', 'DESC')->get()
        ], 200);
    }

    public function show($id)
    {
        $client_agent_chat = ClientAgentChat::find($id);
        if ($client_agent_chat) {
            return response([
                'chat' => $client_agent_chat
            ], 200);
        }
        return response([
            'exception' => 'Chat not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = ClientAgentChat::query();

        if ($request->search) {
            $query = $query->where('message', 'like', '%' . $request->search . '%');
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


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'client_id' => 'required|integer',
            'attachment' => 'nullable|file',
            'image' => 'nullable|image',
            'message' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $attachmentUrl = '';
        $imageUrl = '';

        if ($request->attachment != NULL) {
            $image = $request->file('attachment');
            $filename = uniqid('attachment_', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('/', $filename);
            $attachmentUrl = $filename;
        }

        if ($request->image != NULL) {
            $image = $request->file('image');
            $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('/', $filename);
            $imageUrl = $filename;
        }


        if ($request->user_id) {
            $checkUser = User::find($request->user_id);

            if (!$checkUser) {
                return response([
                    'user' => 'User not found'
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

        $chat = ClientAgentChat::create([
            'user_id' => $request->user_id,
            'client_id' => $request->client_id,
            'attachment' => $attachmentUrl,
            'image' => $imageUrl,
            'message' => $request->message,
            'is_seen' => false,
            'status' => true
        ]);

        return response([
            'chat' => $chat
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'attachment' => 'nullable|file',
            'image' => 'nullable|image',
            'message' => 'nullable|max:255'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->user_id) {
            $checkUser = User::find($request->user_id);

            if (!$checkUser) {
                return response([
                    'user' => 'User not found'
                ], 404);
            }
        }

        if ($request->created_by) {
            $checkClient = Client::find($request->client_id);

            if (!$checkClient) {
                return response([
                    'created by' => 'Client not found'
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


        $chat = ClientAgentChat::find($id);
        
        if ($chat) {
            if ($request->attachment != NULL) {
                $image = $request->file('attachment');
                $filename = uniqid('attachment_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('/', $filename);
                $attachmentUrl = $filename;
                $chat->attachment = $attachmentUrl;
            }
    
            if ($request->image != NULL) {
                $image = $request->file('image');
                $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('/', $filename);
                $imageUrl = $filename;

                $chat->image = $imageUrl;
            }

            $chat->message = isset($request->message) ? $request->message : $chat->message ;

            $chat->save();
    
            return response([
                'chat' => $chat
            ], 200);
        }
        
        return response([
            'exception' => 'Chat not found'    
        ], 404);
    }

    public function destroy($id)
    {
        $data = ClientAgentChat::find($id);
        if ($data) {
            $data->delete();
            return response([
                'message' => 'Data deleted',
                'data' => $data
            ], 200);
        }
        
        return response([
            'exeception' => 'Chat not found'
        ], 404);
    }
}
