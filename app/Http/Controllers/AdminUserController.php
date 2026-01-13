<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display list of users with search & filter.
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('userid', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        // Filter by role (Laratrust uses 'name' not slug)
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $roles = Role::all(); // laratrust roles
        $users = $query->paginate(20);

        return view('user_management.admin.admin_user_list', compact('users', 'roles'));
    }

    /**
     * Export users to CSV.
     */
    public function export(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('userid', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->get();

        $filename = 'users_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'UserID', 'Student ID', 'Name', 'Email', 'Role', 'Status', 'Phone', 'Created At']);

            $no = 1;
            foreach ($users as $user) {
                $role = $user->role->name ?? '—';

                fputcsv($file, [
                    $no++,
                    $user->userid,
                    $user->student_id,
                    $user->name,
                    $user->email,
                    $role,
                    $user->is_active ? 'Active' : 'Inactive',
                    $user->phone_num,
                    $user->created_at?->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Store (create new user)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', 'unique:users'],
            'student_id' => ['required', 'unique:users,student_id'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'role_id'    => ['required', Rule::exists('roles', 'id')],
            'status'     => ['required', Rule::in(['ACTIVE', 'INACTIVE'])],
            'phone_num'  => ['nullable', 'string', 'max:20'],
            'categories'   => ['nullable', 'array'], // Must be an array
            'categories.*' => ['exists:categories,id'], // Each item must exist in DB
        ]);

        // Create user first
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_active' => $request->status === 'ACTIVE',
            'phone_num' => $request->phone_num,
            'student_id'=> $request->student_id,
            'role_id'   => $request->role_id,
        ]);

        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }

        $user->syncRoles([$request->role_id]);

        return redirect()->route('userlist')->with('success', 'User created successfully.');
    }

    // delete user
    public function destroy($id)
    {
        // Find the user or fail
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Return a JSON response for the AJAX call
        return response()->json(['success' => 'User deleted successfully']);
    }

    // In app/Http/Controllers/AdminUserController.php

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 1. VALIDATION
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'student_id' => ['required', Rule::unique('users', 'student_id')->ignore($user->id)],
            'is_active'  => ['required', 'boolean'],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],

            // 2. Add validation for categories
            'categories'   => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ]);

        // 3. Update User Details
        $dataToUpdate = [
            'name'       => $request->name,
            'email'      => $request->email,
            'is_active'  => $request->is_active,
            'student_id' => $request->student_id,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $user->update($dataToUpdate);

        // 4. SYNC CATEGORIES (The Critical Part)
        // This automatically adds new checks and removes unchecked ones.
        // We only do this if the user is a Technician.
        if ($user->role_id == 3 || $user->hasRole('technician')) {
            $user->categories()->sync($request->categories ?? []);
        }

        return redirect()->route('userlist')->with('success', 'User updated successfully.');
    }

    public function create(Request $request)
    {
        // ... existing code ...

        // 1. ADD THIS LINE
        $categories = \App\Models\Category::all();

        // 2. PASS IT TO THE VIEW
        return view('user_management.admin.admin_tech_create', compact('categories'));
    }
}
