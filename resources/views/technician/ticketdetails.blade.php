@extends('layouts.app')

@section('title', 'Technician Ticket Details')
@section('page-header', 'Ticket Details')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm" style="width: 80%;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Ticket Details</h3>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Ticket Number</h6>
                <p class="fs-6 mb-0">{{ $ticket->ticket_number }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Student ID</h6>
                <p class="fs-6 mb-0">{{ $ticket->user->student_id ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Title</h6>
                <p class="fs-6 mb-0">{{ $ticket->title }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Category</h6>
                <p class="fs-6 mb-0">{{ $ticket->category->name ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Description</h6>
                <p class="fs-6 mb-0">{{ $ticket->description }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Location</h6>
                <p class="fs-6 mb-0">{{ $ticket->location }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Date Service Not Function</h6>
                <p class="fs-6 mb-0">{{ optional($ticket->raised_date)->format('d/m/Y H:i') ?? '-' }}</p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Resolved Date</h6>
                <p class="fs-6 mb-0">
                    @if ($ticket->status === 'completed' && $ticket->resolved_date)
                        {{ $ticket->resolved_date->format('d/m/Y H:i') }}
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Status</h6>
                @if (strtolower($ticket->status) === 'completed')
                    <span class="badge bg-success text-white fs-6">Completed</span>
                @elseif (strtolower($ticket->status) === 'pending')
                    <span class="badge bg-warning text-white fs-6">Pending</span>
                @elseif (strtolower($ticket->status) === 'cancel')
                    <span class="badge bg-danger text-white fs-6">Cancel</span>
                @else
                    <span class="badge bg-secondary text-white fs-6">Unknown</span>
                @endif
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('technician.ticket.list') }}" class="btn btn-light me-3">Back</a>
            <a href="{{ route('technician.ticket.update', $ticket->id) }}" class="btn btn-sm btn-info fs-6">
                Update
            </a>
        </div>
    </div>
</div>
@endsection
