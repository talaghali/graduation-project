<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of admins
     */
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->withCount('stories')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('dashboard.admins.create');
    }

    /**
     * Store a newly created admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'password' => 'required|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = true;
        $validated['terms_accepted'] = true;

        $admin = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully!',
            'admin_id' => $admin->id,
            'redirect_url' => route('dashboard.admins.index')
        ]);
    }

    /**
     * Display the specified admin with their stories
     */
    public function show(User $admin)
    {
        // Prevent viewing non-admin users
        if (!$admin->is_admin) {
            abort(404);
        }

        // Load stories count
        $admin->loadCount('stories');

        // Load admin's stories with pagination
        $stories = $admin->stories()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.admins.show', compact('admin', 'stories'));
    }

    /**
     * Show the form for editing the specified admin
     */
    public function edit(User $admin)
    {
        // Prevent editing non-admin users
        if (!$admin->is_admin) {
            abort(404);
        }

        return view('dashboard.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin
     */
    public function update(Request $request, User $admin)
    {
        // Prevent updating non-admin users
        if (!$admin->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'User is not an admin.'
            ], 403);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($admin->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Admin updated successfully!',
            'admin_id' => $admin->id,
            'redirect_url' => route('dashboard.admins.index')
        ]);
    }

    /**
     * Remove the specified admin
     */
    public function destroy(User $admin)
    {
        // Prevent deleting non-admin users
        if (!$admin->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'User is not an admin.'
            ], 403);
        }

        // Prevent admin from deleting themselves
        if ($admin->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 403);
        }

        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully!'
        ]);
    }
}
