<?php

namespace App\Http\Controllers;

use App\Models\feedback;
use App\Models\Ticket;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentId = Auth::id(); // get the logged-in student

        $feedback = Feedback::where('user_id', $studentId)
                            ->with(['ticket.technician', 'student'])
                            ->get();
        $data = [
            'feedback' => $feedback,
        ];

        return  view ('feedback.index', $data);

    }

    public function index_admin()
    {
        $feedback = Feedback::with(['student', 'ticket.technician'])->get();

        $data = [
            'feedback' => $feedback,
        ];

        return  view ('feedback.index-admin',$data);
    }

    public function index_technian()
    {
        $technicianId = Auth::id();

        $feedback = Feedback::whereHas('ticket', function ($query) use ($technicianId) {
            $query->where('assigned_technician_id', $technicianId);
        })->with(['ticket', 'student'])->get();



        $data = [
            'feedback' => $feedback,
        ];

        return  view ('feedback.index-technian',$data);

    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create($ticketNumber)
    // {
    //     $ticket = Ticket::where('ticket_number', $ticketNumber)
    //                     ->with('technician')
    //                     ->firstOrFail();

    //     return view('feedback.create', compact('ticket'));
    // }
    public function create($ticketId)
    {
        $ticket = Ticket::with('technician')->findOrFail($ticketId);

        return view('feedback.create', compact('ticket'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error('Error!', 'Please fill in all required fields.');
            return back()->withErrors($validator)->withInput();
        }

        Feedback::create([
            'ticket_id' => $request->ticket_id,
            'user_id'  => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        Alert::success('Thank you!', 'Your feedback has been submitted successfully.');
        return redirect()->route('feedback.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
