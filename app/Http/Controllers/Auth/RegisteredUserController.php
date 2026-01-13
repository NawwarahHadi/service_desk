<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // <--- 1. IMPORT YOUR ROLE MODEL
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'student_id' => ['required', 'string', 'max:255', 'unique:users,student_id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. FETCH THE ROLE FROM DATABASE
        // We find the role by name so we get the ID and the Object
        $studentRole = Role::where('name', 'student')->first();

        // Safety check: Create role if it doesn't exist (Optional but recommended for dev)
        if (!$studentRole) {
            $studentRole = Role::create(['name' => 'student', 'display_name' => 'Student']);
        }

        // 3. CREATE USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'password' => Hash::make($request->password),
            'is_active' => true,

            // Save to 'users' table (One-to-Many)
            'role_id' => $studentRole->id,
        ]);

        // 4. ATTACH TO PIVOT TABLE (Laratrust)
        // This saves the data into the 'role_user' database table
        $user->attachRole($studentRole);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Account registered successfully. Please log in.');
    }
}
