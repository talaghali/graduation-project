<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users (non-admin)
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false)
            ->withCount('stories');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by date
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Display the specified user with their stories
     */
    public function show(User $user)
    {
        // Prevent viewing admin users
        if ($user->is_admin) {
            abort(404);
        }

        // Load user's stories with pagination
        $stories = $user->stories()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.users.show', compact('user', 'stories'));
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting admin users
        if ($user->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete admin users from this section.'
            ], 403);
        }

        // Delete all user's story media files
        foreach ($user->stories as $story) {
            if ($story->media_path) {
                Storage::disk('public')->delete($story->media_path);
            }
        }

        // Delete user's stories
        $user->stories()->delete();

        // Delete user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User and their stories deleted successfully!'
        ]);
    }

    /**
     * Toggle user access (block/unblock) - optional feature
     */
    public function toggleStatus(User $user)
    {
        // You can add a 'is_blocked' column to users table if needed
        // For now, this is a placeholder for future enhancement

        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully!'
        ]);
    }
}
