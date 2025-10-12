<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $topics = Topic::with('lecturer')->get();
         return response()->json($topics, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lecturer_id' => 'required|exists:lecturers,id',
            'topic_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirement' => 'nullable|string',
            'limit_supervise' => 'integer|min:0',
            'limit_applied' => 'integer|min:0',
        ]);

        $lecturerHasTopic = Topic::where('lecturer_id', $validated['lecturer_id'])->exists();

        if ($lecturerHasTopic) {
            return response()->json([
                'message' => 'This lecturer already has a topic assigned.'
            ], 400);
        }

        $topic = Topic::create($validated);

        return response()->json([
            'message' => 'Topic created successfully',
            'data' => $topic
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = Topic::with('lecturer')->find($id);
        if (!$topic) {
            return response()->json(['message' => 'Topic not found'], 404);
        }

        return response()->json($topic, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['message' => 'Topic not found'], 404);
        }

        $topic->update($request->all());
        return response()->json(['message' => 'Topic updated', 'data' => $topic], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['message' => 'Topic not found'], 404);
        }

        $topic->delete();
        return response()->json(['message' => 'Topic deleted'], 200);
    }
}
