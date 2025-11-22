<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show dashboard login page
     */
    public function showLogin()
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('dashboard.index');
        }

        return view('dashboard.auth.login');
    }

    /**
     * Handle dashboard login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            if (auth()->user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard.index'));
            }

            auth()->logout();
            return back()->with('error', 'Unauthorized access. Admin access only.');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    /**
     * Dashboard overview
     */
    public function index()
    {
        $stats = [
            'total_stories' => Story::count(),
            'pending_stories' => Story::pending()->count(),
            'approved_stories' => Story::approved()->count(),
            'rejected_stories' => Story::rejected()->count(),
            'total_users' => User::count(),
        ];

        $recent_stories = Story::with('user')->latest()->limit(10)->get();

        return view('dashboard.index', compact('stats', 'recent_stories'));
    }

    /**
     * Logout from dashboard
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login');
    }
}
