<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    // ======================
    // Ticket List
    // ======================
    public function index()
    {
        $tickets = Ticket::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('raised_date', 'desc')
            ->get();

        return view('complaintmodule.ticketlistdata', compact('tickets'));
    }

    // ======================
    // Create Ticket Page
    // ======================
    public function create()
    {
        $categories = Category::all();
        return view('complaintmodule.createticket', compact('categories'));
    }

    // ======================
    // Store Ticket
    // ======================
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'category_id' => 'required|exists:categories,id',
        //     'description' => 'required|string',
        //     'location' => 'required|string|max:255',
        //     'raised_date' => 'required|date',
        // ]);

        Ticket::create([
            'ticket_number' => 'TCK-' . strtoupper(Str::random(6)),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'raised_date' => $request->raised_date,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('complaint.ticket.list')
            ->with('success', 'Ticket created successfully!');
    }

    // ======================
    // Ticket Details
    // ======================
    public function show($ticket_number)
    {
        $ticket = Ticket::with('category')
            ->where('ticket_number', $ticket_number)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('complaintmodule.ticketdetails', compact('ticket'));
    }
}
