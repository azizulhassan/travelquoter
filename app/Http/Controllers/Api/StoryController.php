<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\StoryComment;
use App\Models\StoryLike;
use App\Models\StoryTag;
use App\Models\SubscribeAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{

    public function assignTag(Request $request) {
        $validator = Validator::make($request->all(), [
            'story_tag_id' => 'required|integer|exists:story_tags,id',
            'story_id' => 'required|integer|exists:stories,id'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $storyTag = StoryTag::create($request->all());

        return response([
            'tag_assigned' => $storyTag,
        ], 200);
    }

    public function comment(Request $request) {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'nullable|integer|exists:agents,id',
            'client_id' => 'nullable|integer|exists:clients,id',
            'story_id' => 'required|integer|exists:stories,id',
            'comment' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $comment = StoryComment::create($request->all());

        return response([
            'comment' => $comment,
        ], 200);
    }

    public function tags() {
        return response([
            'tags' => StoryTag::where('status', true)->get(),
        ], 200);
    }

    public function like(Request $request) {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'nullable|integer|exists:agents,id',
            'client_id' => 'nullable|integer|exists:clients,id',
            'story_id' => 'required|integer|exists:stories,id',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        if ($request->has('client_id')) {
            if (StoryLike::where('client_id', $request->client_id)->where('story_id', $request->story_id)->first()) {
                return response([
                    'message' => 'Story already liked'
                ], 200);
            }
        }

        if ($request->has('agent_id')) {
            if (StoryLike::where('agent_id', $request->agent_id)->where('story_id', $request->story_id)->first()) {
                return response([
                    'message' => 'Story already liked'
                ], 200);
            }
        }

        $storyLike = StoryLike::create($request->all());

        return response([
            'story_like' => $storyLike,
        ], 200);
    }


    public function subscribeAgent(Request $request) {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'required|exists:agents,id',
            'client_id' => 'required|exists:clients,id',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $subscribeAgents = SubscribeAgent::create($request->all());

        return response([
            'data' => $subscribeAgents,
        ], 200);
    }

    public function index()
    {
        return response([
            'stories' => Story::where('status', true)->paginate(20),
        ], 200);
    }


    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'agent_id' => 'nullable|exists:agents,id',
            'category' => 'required|string|max:255',
            'content' => 'nullable|string|max:5000',
            'image' => 'nullable|image',
            'video' => 'nullable|video',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }

        $videoUrl = '';
        $imageUrl = '';

        if ($request->video != NULL) {
            $video = $request->file('video');
            $filename = uniqid('video_', true) . '.' . $video->getClientOriginalExtension();
            $video->storeAs('/', $filename);
            $videoUrl = $filename;
        }

        if ($request->image != NULL) {
            $image = $request->file('image');
            $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('/', $filename);
            $imageUrl = $filename;
        }

        $story = Story::create([
            'agent_id' => $request->agent_id,
            'category' => $request->category,
            'content' => $request->content,
            'image' => $imageUrl,
            'video' => $videoUrl,
        ]);

        return response([
            'story' => $story
        ], 200);
    }


    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'content' => 'nullable|string|max:5000',
            'image' => 'nullable|image',
            'video' => 'nullable|video',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 404);
        }
        
        $story = Story::find($id);

        if ($story) {
            if ($request->video != NULL) {
                $video = $request->file('video');
                $filename = uniqid('video_', true) . '.' . $video->getClientOriginalExtension();
                $video->storeAs('/', $filename);
                $videoUrl = $filename;

                $story->video = $videoUrl;
            }
    
            if ($request->image != NULL) {
                $image = $request->file('image');
                $filename = uniqid('image_', true) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('/', $filename);
                $imageUrl = $filename;

                $story->image = $imageUrl;
            }
            
            $story->category = isset($request->category) ? $request->category : $story->category;
            $story->content = isset($request->content) ? $request->content : $story->content;

            $story->save();

            return response([
                'story' => $story
            ], 200);
        }
        
        return response([
            'exception' => 'Story not found'    
        ], 404);
    }


    public function category() {
        return response([
            'category' => [
                'Flights',
                'Hotel',
                'Car',
                'Visa',
                'Insurance'
            ]
        ], 200);
    }

    public function show($id)
    {
        $story = Story::find($id);
        if ($story) {
            return response([
                'story' => $story,
            ], 200);
        }
        return response([
            'exception' => 'Story not found'
        ], 404);
    }

    public function search(Request $request)
    {
        $query = Story::query();

        if ($request->has('content')) {
            $query = $query->where('content', 'like', '%'. $request->content . '%');
        }

        if ($request->has('category')) {
            $query = $query->where('category', 'like', '%'. $request->category .'%');
        }

        if ($request->has('sort')) {
            if ($request->sort == 'ASC') {
                $query = $query->orderBy('created_at', 'ASC');
            }
            else {
                $query = $query->orderBy('created_at', 'DESC');
            }
        }
        else {
            $query = $query->orderBy('created_at', 'DESC');
        }

        $query = $query->paginate(12);
        
        return response([
            'search' => $query
        ], 200);
    }
}
