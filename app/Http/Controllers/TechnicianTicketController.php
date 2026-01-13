<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianTicketController extends Controller
{
    /* ===================== TICKET LIST ===================== */
    public function index()
    {
        $technicianId = Auth::id(); // logged-in technician

        $tickets = Ticket::with(['user', 'category'])
            ->where('assigned_technician_id', $technicianId)
            ->orderBy('raised_date', 'desc')
            ->get();

        return view('technician.ticketlist', compact('tickets'));
    }

    /* ===================== TICKET DETAILS ===================== */
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'category'])
            ->where('assigned_technician_id', Auth::id())
            ->findOrFail($id);

        return view('technician.ticketdetails', compact('ticket'));
    }

    /* ===================== UPDATE PAGE ===================== */
    public function edit($id)
    {
        $ticket = Ticket::where('assigned_technician_id', Auth::id())
            ->findOrFail($id);

        return view('technician.ticketupdate', compact('ticket'));
    }

    /* ===================== UPDATE SUBMIT ===================== */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancel',
            'technician_comment' => 'nullable|string',
        ]);

        $ticket = Ticket::where('assigned_technician_id', Auth::id())
            ->findOrFail($id);

        $ticket->status = $request->status;
        $ticket->technician_comment = $request->technician_comment;

        if ($request->status === 'completed') {
            $ticket->resolved_date = now();
        }

        $ticket->save();

        return redirect()
            ->route('technician.ticket.list')
            ->with('success', 'Ticket updated successfully!');
    }
}
