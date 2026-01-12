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
        $query = User::with('roles');

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
                $role = $user->roles->first()->name ?? '—';

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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id'     => ['required', Rule::exists('roles', 'id')], // laratrust role id
            'status'   => ['required', Rule::in(['ACTIVE', 'INACTIVE'])],
            'phone_num'=> ['nullable', 'string', 'max:20'],
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

        // If you are using Laratrust (which uses a separate table),
        // you can attach the ID directly.
        // If you are NOT using Laratrust's pivot table, you can delete this line.
        if (method_exists($user, 'attachRole')) {
            $user->attachRole($request->role_id);
        }

        return redirect()->route('userlist')->with('success', 'User created successfully.');
    }
}
