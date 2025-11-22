<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HighlightManagementController extends Controller
{
    /**
     * Display a listing of highlights
     */
    public function index()
    {
        $highlights = Highlight::ordered()->paginate(10);

        return view('dashboard.highlights.index', compact('highlights'));
    }

    /**
     * Show the form for creating a new highlight
     */
    public function create()
    {
        return view('dashboard.highlights.create');
    }

    /**
     * Store a newly created highlight
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:youtube,vimeo,local',
            'video_url' => 'required|string',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:512000', // 500MB max
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240', // 10MB max
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Handle local video upload
        if ($request->video_type === 'local' && $request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('highlights/videos', 'public');
            $validated['video_url'] = $videoPath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('highlights/thumbnails', 'public');
            $validated['thumbnail_path'] = $thumbnailPath;
        }

        $highlight = Highlight::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Highlight created successfully!',
            'highlight_id' => $highlight->id,
            'redirect_url' => route('dashboard.highlights.index')
        ]);
    }

    /**
     * Show the form for editing the specified highlight
     */
    public function edit(Highlight $highlight)
    {
        return view('dashboard.highlights.edit', compact('highlight'));
    }

    /**
     * Update the specified highlight
     */
    public function update(Request $request, Highlight $highlight)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_type' => 'required|in:youtube,vimeo,local',
            'video_url' => 'required|string',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:512000',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240',
            'remove_thumbnail' => 'nullable|boolean',
            'remove_video' => 'nullable|boolean',
            'is_active' => 'required|boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Remove old video if requested
        if ($request->has('remove_video') && $request->remove_video && $highlight->video_type === 'local' && $highlight->video_url) {
            Storage::disk('public')->delete($highlight->video_url);
            $validated['video_url'] = '';
        }

        // Handle local video upload
        if ($request->video_type === 'local' && $request->hasFile('video_file')) {
            // Delete old video if exists
            if ($highlight->video_type === 'local' && $highlight->video_url) {
                Storage::disk('public')->delete($highlight->video_url);
            }
            $videoPath = $request->file('video_file')->store('highlights/videos', 'public');
            $validated['video_url'] = $videoPath;
        }

        // Remove old thumbnail if requested
        if ($request->has('remove_thumbnail') && $request->remove_thumbnail && $highlight->thumbnail_path) {
            Storage::disk('public')->delete($highlight->thumbnail_path);
            $validated['thumbnail_path'] = null;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($highlight->thumbnail_path) {
                Storage::disk('public')->delete($highlight->thumbnail_path);
            }
            $thumbnailPath = $request->file('thumbnail')->store('highlights/thumbnails', 'public');
            $validated['thumbnail_path'] = $thumbnailPath;
        }

        $highlight->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Highlight updated successfully!',
            'highlight_id' => $highlight->id,
            'redirect_url' => route('dashboard.highlights.index')
        ]);
    }

    /**
     * Toggle highlight active status
     */
    public function toggleStatus(Highlight $highlight)
    {
        $highlight->update([
            'is_active' => !$highlight->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
            'is_active' => $highlight->is_active,
            'status_text' => $highlight->status_text,
            'badge_color' => $highlight->status_badge_color
        ]);
    }

    /**
     * Remove the specified highlight
     */
    public function destroy(Highlight $highlight)
    {
        // Delete associated files
        if ($highlight->thumbnail_path) {
            Storage::disk('public')->delete($highlight->thumbnail_path);
        }

        if ($highlight->video_type === 'local' && $highlight->video_url) {
            Storage::disk('public')->delete($highlight->video_url);
        }

        $highlight->delete();

        return response()->json([
            'success' => true,
            'message' => 'Highlight deleted successfully!'
        ]);
    }
}
