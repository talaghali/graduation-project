<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    /**
     * Display home page with featured stories
     */
    public function home()
    {
        $stories = Story::approved()
            ->latest()
            ->limit(6)
            ->get();

        $highlights = Highlight::active()
            ->ordered()
            ->get();

        // Calculate statistics from database
        $stats = [
            'stories_count' => Story::approved()->count(),
            'media_count' => Story::approved()->whereNotNull('media_path')->count(),
            'audio_count' => Story::approved()->where('media_type', 'audio')->count(),
            'contributors_count' => Story::approved()->whereNotNull('name')->distinct('name')->count('name'),
        ];

        return view('website.pages.index', compact('stories', 'highlights', 'stats'));
    }

    /**
     * Display all approved stories
     */
    public function index()
    {
        $stories = Story::approved()
            ->latest()
            ->paginate(12);

        return view('website.pages.stories.index', compact('stories'));
    }

    /**
     * Show a single story
     */
    public function show(Story $story)
    {
        // Only show approved stories or owner's stories
        if (!$story->isApproved() && (!Auth::check() || Auth::id() !== $story->user_id)) {
            abort(404);
        }

        return view('website.pages.stories.show', compact('story'));
    }

    /**
     * Show the share story form
     */
    public function create()
    {
        return view('website.pages.share');
    }

    /**
     * Store a new story
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:150',
            'location' => 'nullable|string|max:255',
            'story_type' => 'nullable|string|max:255',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200', // 50MB max
        ]);

        // Handle file upload
        $mediaPath = null;
        $mediaType = null;
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mediaType = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';
            $mediaPath = $file->store('stories', 'public');
        }

        // Create the story
        $story = Story::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'name' => $validated['name'] ?? null,
            'age' => $validated['age'] ?? null,
            'location' => $validated['location'] ?? null,
            'story_type' => $validated['story_type'] ?? null,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'status' => Story::STATUS_PENDING,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Story submitted successfully! It will be reviewed before being published.',
            'story' => $story
        ]);
    }

    /**
     * Show user's own stories
     */
    public function myStories()
    {
        $stories = Auth::user()->stories()->latest()->paginate(10);

        return view('website.pages.stories.my-stories', compact('stories'));
    }

    /**
     * Delete user's own story
     */
    public function destroy(Story $story)
    {
        // Only allow deletion of own stories
        if (Auth::id() !== $story->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete media file if exists
        if ($story->media_path) {
            Storage::disk('public')->delete($story->media_path);
        }

        $story->delete();

        return response()->json([
            'success' => true,
            'message' => 'Story deleted successfully'
        ]);
    }
}
