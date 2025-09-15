<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // Load counts for statistics
        $user->loadCount(['semesters', 'courses']);

        // Sample recent activities (you can replace this with actual activity tracking)
        $recentActivities = collect([
            [
                'icon' => 'book',
                'description' => 'Completed Mathematics 101 - Week 5',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'plan',
                'description' => 'Created new weekly plan for Physics',
                'time' => '1 day ago'
            ],
            [
                'icon' => 'calendar',
                'description' => 'Added new semester Fall 2024',
                'time' => '3 days ago'
            ]
        ]);

        return view('profile.show', [
            'user' => $user,
            'recentActivities' => $recentActivities
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:password', 'current_password', 'min:8'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
