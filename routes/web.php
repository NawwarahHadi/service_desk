<?php
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\TechnicianTicketController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AdminUserController;   // Admin routes for user management
use App\Http\Controllers\UserProfileController;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

// Dashboard route: shows a list of up to 50 users (admin user list)
Route::get('/userlist', [AdminUserController::class, 'index'])->middleware(['auth', 'verified'])->name('userlist');

// Add export route
Route::get('/admin/users/export', [AdminUserController::class, 'export'])->middleware(['auth', 'verified'])->name('admin.users.export');

// Group admin user management routes with middleware and prefix for clarity and maintainability
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    // Unified store route for both students and technicians
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');

    // Student creation page
    Route::get('/admin_stud_create', function () {
        // Attempt to retrieve hostels for assigning to students, if exist
        $hostels = collect([]);
        if (Schema::hasTable('hostels')) {
            try {
                $hostels = DB::table('hostels')->get();
            } catch (\Exception $e) {
                $hostels = collect([]);
            }
        }
        return view('user_management.admin.admin_stud_create', compact('hostels'));
    })->name('admin.stud.create');

    // Technician creation page - NOW USES CONTROLLER
    Route::get('/admin_tech_create', [AdminUserController::class, 'create'])
        ->name('admin.tech.create');
});

// Admin: show user edit page for a specific user
Route::get('/admin/users/{user}/update', function (\App\Models\User $user) {
    $roles = \Illuminate\Support\Facades\DB::table('roles')->get();
    return view('user_management.admin.admin_user_update', compact('user', 'roles'));
})->name('admin.users.edit');

Route::patch('/admin/users/{id}/update', [AdminUserController::class, 'update'])
    ->name('admin.users.update');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {

    // User list
    Route::get('/userlist', [AdminUserController::class, 'index'])->name('admin.userlist');


    // Export users
    Route::get('/users/export', [AdminUserController::class, 'export'])->name('admin.users.export');

    // Store new users (student / technician)
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');

    // Student creation page
    Route::get('/student/create', function () {
        $hostels = DB::table('hostels')->get() ?? collect([]);
        return view('user_management.admin.admin_stud_create', compact('hostels'));
    })->name('admin.student.create');

    // Technician creation page - NOW USES CONTROLLER
    Route::get('/technician/create', [AdminUserController::class, 'create'])
        ->name('admin.technician.create');

    // edit user
    Route::get('/users/{user}/edit', function (\App\Models\User $user) {
        // Laratrust way to load all roles
        $roles = \App\Models\Role::all();
        return view('user_management.admin.admin_user_update', compact('user', 'roles'));
    })->name('admin.users.edit');

    // Destroy user (delete)
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return Auth::check()
//         ? redirect('/dashboard')
//         : redirect('/login');
// });


// Route::redirect('/', '/dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboardadmin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified',])
    ->name('dashboard');

Route::get('/dashboard/student', [DashboardController::class, 'student']) //for student and technician dashboard
    ->middleware(['auth', 'verified'])
    ->name('dashboard.student');

Route::get('/dashboard', [DashboardController::class, 'technian']) //for  technician dashboard
    ->middleware(['auth', 'verified'])
    ->name('dashboard.technian');

Route::middleware('auth')->group(function () {

    //Complaint Ticket Module
    Route::middleware('auth')->group(function () {

    Route::prefix('complaint')->name('complaint.')->group(function () {

        Route::get('/createticket', [TicketController::class, 'create'])
            ->name('ticket.create');

        Route::post('/save', [TicketController::class, 'store'])
            ->name('ticket.store');

        Route::get('/ticketlistdata', [TicketController::class, 'index'])
            ->name('ticket.list');

        Route::get('/ticket/{ticket_number}', [TicketController::class, 'show'])
            ->name('ticket.details');
    });
});



    //Feedback
    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/index', [FeedbackController::class, 'index'])->name('index');
        Route::get('/Admin', [FeedbackController::class, 'index_admin'])->name('index_admin');
        Route::get('/technian', [FeedbackController::class, 'index_technian'])->name('index_technian');
        Route::get('/create/{ticket}', [FeedbackController::class, 'create'])->name('create');
        Route::post('/save', [FeedbackController::class, 'store'])->name('save');
    });

    //Admin Ticket
    Route::prefix('admin')->group(function () {
        Route::get('/tickets', [AdminTicketController::class, 'index'])->name('admin.ticket.list');
        Route::get('/tickets/{id}', [AdminTicketController::class, 'show'])->name('admin.ticket.details');
        Route::post('/tickets/assign', [AdminTicketController::class, 'assignTechnician'])->name('admin.assign.technician');
    });

    // Technician
    Route::prefix('technician')->group(function () {

        Route::get('/tickets', [TechnicianTicketController::class, 'index'])
            ->name('technician.ticket.list');

        Route::get('/tickets/{id}', [TechnicianTicketController::class, 'show'])
            ->name('technician.ticket.details');

        Route::get('/tickets/{id}/update', [TechnicianTicketController::class, 'edit'])
            ->name('technician.ticket.update');

        Route::post('/tickets/{id}/update', [TechnicianTicketController::class, 'update'])
            ->name('technician.ticket.update.submit');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student profile
    Route::get('/student/profile', [UserProfileController::class, 'editStudent'])->name('student.profile.edit');
    Route::patch('/student/profile', [UserProfileController::class, 'updateStudent'])->name('student.profile.update');

    // Technician profile
    Route::get('/technician/profile', [UserProfileController::class, 'editTechnician'])->name('technician.profile.edit');
    Route::patch('/technician/profile', [UserProfileController::class, 'updateTechnician'])->name('technician.profile.update');
});


//Complaint Ticket Module

// Route::get('/createticket', function () {
//     return view('complaintmodule.createticket');
// });

// Route::get('/ticketlistdata', [TicketController::class, 'index'])->name('ticket.list');

// Route::get('/ticket/{id}', [TicketController::class, 'show'])->name('ticket.details');

// test technician
Route::middleware(['auth'])->prefix('technician')->name('technician.')->group(function () {

    Route::get('/tickets', [TechnicianTicketController::class, 'index'])
        ->name('ticket.list');

    Route::get('/tickets/{id}', [TechnicianTicketController::class, 'show'])
        ->name('ticket.details');

    Route::get('/tickets/{id}/update', [TechnicianTicketController::class, 'edit'])
        ->name('ticket.update');

    Route::post('/tickets/{id}/update', [TechnicianTicketController::class, 'update'])
        ->name('ticket.update.submit');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/tickets', [AdminTicketController::class, 'index'])
        ->name('ticket.list');

    Route::get('/tickets/{id}', [AdminTicketController::class, 'show'])
        ->name('ticket.details');

    Route::post('/assign-technician', [AdminTicketController::class, 'assignTechnician'])
        ->name('assign.technician');
});


require __DIR__.'/auth.php';
