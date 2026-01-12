<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    /* ===================== TICKET LIST ===================== */
    public function index()
    {
        $tickets = Ticket::with(['user', 'category', 'technician'])
            ->orderBy('raised_date', 'desc')
            ->get();

        $technicians = User::where('role_id', 3) // technician
            ->with('categories')
            ->get()
            ->map(function ($tech) {
                return [
                    'id' => $tech->id,
                    'name' => $tech->name,
                    'categories' => $tech->categories->map(function ($cat) {
                        return [
                            'id' => $cat->id,
                            'name' => $cat->name,
                        ];
                    }),
                ];
            });

        return view('admin.ticketlist', compact('tickets', 'technicians'));
    }

    /* ===================== ASSIGN TECHNICIAN ===================== */
    public function assignTechnician(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'technician_id' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if ($ticket->status !== 'pending') {
            return back()->with('error', 'Only pending tickets can be assigned.');
        }

        $ticket->assigned_technician_id = $request->technician_id;
        $ticket->save();

        return back()->with('success', 'Technician assigned successfully.');
    }

    /* ===================== TICKET DETAILS ===================== */
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'category', 'technician'])
            ->findOrFail($id);

        // 🔴 THIS WAS MISSING BEFORE
        $technicians = User::where('role_id', 3) // technician
            ->with('categories')
            ->get()
            ->map(function ($tech) {
                return [
                    'id' => $tech->id,
                    'name' => $tech->name,
                    'categories' => $tech->categories->map(function ($cat) {
                        return [
                            'id' => $cat->id,
                            'name' => $cat->name,
                        ];
                    }),
                ];
            });

        return view('admin.ticketdetails', compact('ticket', 'technicians'));
    }
}
