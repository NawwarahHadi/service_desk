<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Show Student Profile
     */
    public function editStudent(Request $request): View
    {
        $user = $request->user();

        // Laratrust role check
        if (!$user->hasRole('student')) {
            abort(403, 'You are not authorized to access this page.');
        }

        return view('user_management.student.stud_profile_view', compact('user'));
    }

    /**
     * Update Student Profile
     */
    public function updateStudent(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user->hasRole('student')) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required','email','max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'student_id' => ['required', Rule::unique('users', 'student_id')->ignore($user->id)],
            'phone_num'  => ['nullable', 'string', 'max:255'],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name       = $validated['name'];
        $user->email      = $validated['email'];
        $user->student_id = $validated['student_id'];
        $user->phone_num  = $validated['phone_num'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully.');
    }

    /**
     * Show Technician Profile
     */
    public function editTechnician(Request $request): View
    {
        $user = $request->user();

        // 1. Load the categories relationship
        $user->load('categories');

        if (!$user->hasRole('technician')) {
            abort(403, 'Unauthorized.');
        }

        return view('user_management.technician.tech_profile_view', compact('user'));
    }

    /**
     * Update Technician Profile
     */
    public function updateTechnician(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user->hasRole('technician')) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],

            // 1. ADD THIS LINE (Validate the student_id)
            'student_id' => ['required', Rule::unique('users', 'student_id')->ignore($user->id)],

            'phone_num'  => ['nullable', 'string', 'max:255'],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name       = $validated['name'];
        $user->email      = $validated['email'];

        // 2. ADD THIS LINE (Assign the new value)
        $user->student_id = $validated['student_id'];

        $user->phone_num  = $validated['phone_num'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully.');
    }
}
