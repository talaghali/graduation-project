<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\StoryDeleteRequest;
use Illuminate\Http\Request;

class DeleteRequestManagementController extends Controller
{
    /**
     * Display a listing of delete requests
     */
    public function index(Request $request)
    {
        $query = StoryDeleteRequest::with(['story', 'user', 'handledBy']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default to showing pending requests
            $query->where('status', 'pending');
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.delete-requests.index', compact('requests'));
    }

    /**
     * Display the specified delete request
     */
    public function show(StoryDeleteRequest $deleteRequest)
    {
        $deleteRequest->load(['story', 'user', 'handledBy']);
        return view('dashboard.delete-requests.show', compact('deleteRequest'));
    }

    /**
     * Approve delete request
     */
    public function approve(Request $request, StoryDeleteRequest $deleteRequest)
    {
        if ($deleteRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been handled.'
            ], 422);
        }

        try {
            // Update request status
            $deleteRequest->update([
                'status' => 'approved',
                'handled_by' => auth()->id(),
                'handled_at' => now(),
                'admin_notes' => $request->input('admin_notes')
            ]);

            // Delete the story and associated media
            $story = $deleteRequest->story;
            if ($story) {
                if ($story->media_path) {
                    \Storage::disk('public')->delete($story->media_path);
                }
                $story->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Delete request approved and story deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject delete request
     */
    public function reject(Request $request, StoryDeleteRequest $deleteRequest)
    {
        if ($deleteRequest->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been handled.'
            ], 422);
        }

        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        try {
            $deleteRequest->update([
                'status' => 'rejected',
                'handled_by' => auth()->id(),
                'handled_at' => now(),
                'admin_notes' => $request->input('admin_notes')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delete request rejected successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
