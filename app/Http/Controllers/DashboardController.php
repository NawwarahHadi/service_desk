<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Ticket;
use App\Models\feedback;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // direct DB counts using role relation (Laratrust or your roles relation)
        $totalStudents = User::whereHas('roles', function ($q) {
            $q->where('name', 'Student');
        })->count();

        $totalTechnicians = User::whereHas('roles', function ($q) {
            $q->where('name', 'Technician');
        })->count();

        // Real ticket status counts
        $complaintData = [
            ['category' => 'Completed', 'value' => Ticket::where('status', 'completed')->count()],
            ['category' => 'Pending', 'value' => Ticket::where('status', 'pending')->count()],
            ['category' => 'Cancel', 'value' => Ticket::where('status', 'cancel')->count()],
        ];

        // Real feedback rating counts
        $feedbackData = [
            ['rating' => '1 Star', 'count' => feedback::where('rating', 1)->count()],
            ['rating' => '2 Stars', 'count' => feedback::where('rating', 2)->count()],
            ['rating' => '3 Stars', 'count' => feedback::where('rating', 3)->count()],
            ['rating' => '4 Stars', 'count' => feedback::where('rating', 4)->count()],
            ['rating' => '5 Stars', 'count' => feedback::where('rating', 5)->count()],
        ];

        return view('dashboard.index', compact('totalStudents', 'totalTechnicians', 'complaintData', 'feedbackData'));
    }

    public function student()
    {
        // Real ticket status counts for the logged-in student
        $complaintData = [
            ['category' => 'Completed', 'value' => Ticket::where('user_id', auth()->id())->where('status', 'completed')->count()],
            ['category' => 'Pending', 'value' => Ticket::where('user_id', auth()->id())->where('status', 'pending')->count()],
            ['category' => 'Cancel', 'value' => Ticket::where('user_id', auth()->id())->where('status', 'cancel')->count()],
        ];

        // Real feedback rating counts given by the logged-in student
        $feedbackData = [
            ['rating' => '1 Star', 'count' => feedback::where('user_id', auth()->id())->where('rating', 1)->count()],
            ['rating' => '2 Stars', 'count' => feedback::where('user_id', auth()->id())->where('rating', 2)->count()],
            ['rating' => '3 Stars', 'count' => feedback::where('user_id', auth()->id())->where('rating', 3)->count()],
            ['rating' => '4 Stars', 'count' => feedback::where('user_id', auth()->id())->where('rating', 4)->count()],
            ['rating' => '5 Stars', 'count' => feedback::where('user_id', auth()->id())->where('rating', 5)->count()],
        ];

        return view('dashboard.student', compact('complaintData', 'feedbackData'));
    }
    public function technian()
    {
        // Real ticket status counts for tickets assigned to the logged-in technician
        $complaintData = [
            ['category' => 'Completed', 'value' => Ticket::where('assigned_technician_id', auth()->id())->where('status', 'completed')->count()],
            ['category' => 'Pending', 'value' => Ticket::where('assigned_technician_id', auth()->id())->where('status', 'pending')->count()],
            ['category' => 'Cancel', 'value' => Ticket::where('assigned_technician_id', auth()->id())->where('status', 'cancel')->count()],
        ];

        // Real feedback rating counts received by the logged-in technician
        $technicianName = auth()->user()->name;
        $feedbackData = [
            ['rating' => '1 Star', 'count' => feedback::where('rating', 1)->count()],
            ['rating' => '2 Stars', 'count' => feedback::where('rating', 2)->count()],
            ['rating' => '3 Stars', 'count' => feedback::where('rating', 3)->count()],
            ['rating' => '4 Stars', 'count' => feedback::where('rating', 4)->count()],
            ['rating' => '5 Stars', 'count' => feedback::where('rating', 5)->count()],
        ];

        return view('dashboard.technian', compact('complaintData', 'feedbackData'));
    }

}
