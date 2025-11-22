<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryManagementController extends Controller
{
    /**
     * Display stories list
     */
    public function index(Request $request)
    {
        $query = Story::with('user');

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $stories = $query->latest()->paginate(20);

        return view('dashboard.stories.index', compact('stories'));
    }

    /**
     * Show single story
     */
    public function show(Story $story)
    {
        $story->load('user', 'approver');

        return view('dashboard.stories.show', compact('story'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('dashboard.stories.create');
    }

    /**
     * Store new story
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:150',
            'story_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'media' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi|max:102400', // 100MB max
            'status' => 'required|in:pending,approved,rejected'
        ]);

        // Create story
        $story = new Story();
        $story->title = $validated['title'];
        $story->content = $validated['content'];
        $story->name = $validated['name'] ?? null;
        $story->age = $validated['age'] ?? null;
        $story->story_type = $validated['story_type'] ?? null;
        $story->location = $validated['location'] ?? null;
        $story->date = $validated['date'] ?? null;
        $story->status = $validated['status'];
        $story->user_id = auth()->id(); // Associate with admin user

        // Handle media upload
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaType = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
            $path = $file->store('stories', 'public');

            $story->media_path = $path;
            $story->media_type = $mediaType;
        }

        // Save story
        $story->save();

        // If approved, set approver
        if ($story->status === 'approved') {
            $story->approved_by = auth()->id();
            $story->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Story created successfully!',
            'story_id' => $story->id,
            'redirect_url' => route('dashboard.stories.show', $story)
        ]);
    }

    /**
     * Show edit form
     */
    public function edit(Story $story)
    {
        return view('dashboard.stories.edit', compact('story'));
    }

    /**
     * Update story
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'name' => 'nullable|string|max:255',
            'story_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'media' => 'nullable|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi|max:102400', // 100MB max
            'remove_media' => 'nullable|boolean'
        ]);

        // Update story fields
        $story->title = $validated['title'];
        $story->content = $validated['content'];
        $story->name = $validated['name'] ?? null;
        $story->story_type = $validated['story_type'] ?? null;
        $story->location = $validated['location'] ?? null;
        $story->date = $validated['date'] ?? null;

        // Handle media removal
        if ($request->boolean('remove_media') && $story->media_path) {
            \Storage::disk('public')->delete($story->media_path);
            $story->media_path = null;
            $story->media_type = null;
        }

        // Handle new media upload
        if ($request->hasFile('media')) {
            // Delete old media if exists
            if ($story->media_path) {
                \Storage::disk('public')->delete($story->media_path);
            }

            $file = $request->file('media');
            $mediaType = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
            $path = $file->store('stories', 'public');

            $story->media_path = $path;
            $story->media_type = $mediaType;
        }

        // Save all changes
        $story->save();

        return response()->json([
            'success' => true,
            'message' => 'Story updated successfully!',
            'story_id' => $story->id,
            'redirect_url' => route('dashboard.stories.show', $story)
        ]);
    }

    /**
     * Approve story
     */
    public function approve(Story $story)
    {
        $story->approve(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Story approved successfully!'
        ]);
    }

    /**
     * Reject story
     */
    public function reject(Request $request, Story $story)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        $story->reject(auth()->id(), $request->reason);

        return response()->json([
            'success' => true,
            'message' => 'Story rejected successfully!'
        ]);
    }

    /**
     * Update story status
     */
    public function updateStatus(Request $request, Story $story)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'reason' => 'nullable|string|max:500'
        ]);

        $newStatus = $request->status;
        $reason = $request->reason;

        // Update based on new status
        if ($newStatus === 'approved') {
            $story->approve(auth()->id());
            $message = 'Story approved successfully!';
        } elseif ($newStatus === 'rejected') {
            $story->reject(auth()->id(), $reason);
            $message = 'Story rejected successfully!';
        } else {
            // Set back to pending
            $story->update([
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
                'rejection_reason' => null,
            ]);
            $message = 'Story status updated to pending!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'new_status' => $newStatus,
            'badge_color' => $story->status_badge_color
        ]);
    }

    /**
     * Delete story
     */
    public function destroy(Story $story)
    {
        if ($story->media_path) {
            \Storage::disk('public')->delete($story->media_path);
        }

        $story->delete();

        return response()->json([
            'success' => true,
            'message' => 'Story deleted successfully!'
        ]);
    }
}
