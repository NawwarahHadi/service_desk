@extends('layouts.app')

@section('title', 'Admin Ticket Details')
@section('page-header', 'Ticket Details')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm" style="width: 80%;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Ticket Details</h3>
        </div>

        <div class="card-body">
            {{-- Ticket Information --}}
            @php
                $fields = [
                    'Ticket ID' => $ticket->id,
                    'Student ID' => $ticket->userid,
                    'Title' => $ticket->title,
                    'Category' => $ticket->category->name ?? '-', // <-- Fix: get category name
                    'Description' => $ticket->description,
                    'Location' => $ticket->location,
                    'Date Service Not Function' => $ticket->date,
                    'Resolved Date' => ($ticket->status == 'Completed' && $ticket->resolved_date) ? $ticket->resolved_date : '-',
                ];
            @endphp

            @foreach($fields as $label => $value)
                <div class="mb-4">
                    <h6 class="fw-semibold text-muted mb-1">{{ $label }}</h6>
                    <p class="fs-6 mb-0">{{ $value }}</p>
                </div>
            @endforeach

            {{-- Status --}}
            <div class="mb-4">
                <h6 class="fw-semibold text-muted mb-1">Status</h6>
                @if ($ticket->status == 'Completed')
                    <span class="badge bg-success text-white fs-6">Completed</span>
                @elseif ($ticket->status == 'Pending')
                    <span class="badge bg-warning text-white fs-6">Pending</span>
                @elseif ($ticket->status == 'Cancel')
                    <span class="badge bg-danger text-white fs-6">Cancel</span>
                @else
                    <span class="badge bg-secondary text-white fs-6">Unknown</span>
                @endif
            </div>

            {{-- Comment --}}
            @if (!empty($ticket->comment))
                <div class="mb-4">
                    <h6 class="fw-semibold text-muted mb-1">Comment</h6>
                    @if ($ticket->status == 'Completed')
                        <p class="fs-6 mb-0 bg-success-subtle p-3 rounded w-100" style="min-height: 60px;">{{ $ticket->comment }}</p>
                    @elseif ($ticket->status == 'Cancel')
                        <p class="fs-6 mb-0 bg-danger-subtle p-3 rounded w-100" style="min-height: 60px;">{{ $ticket->comment }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.ticket.list') }}" class="btn btn-sm btn-info fs-6">Back</a>

            {{-- Assign Technician button only for pending tickets --}}
            @if($ticket->status == 'Pending')
                <button
                    class="btn btn-sm btn-primary fs-6"
                    data-bs-toggle="modal"
                    data-bs-target="#assignModal">
                    Assign Technician
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Assign Technician Modal --}}
@if($ticket->status == 'Pending')
<div class="modal fade" id="assignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.assign.technician') }}">
            @csrf
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Technician</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label for="technician">Choose Technician</label>
                    <select name="technician_id" id="technician" class="form-select" required>
                        @foreach ($technicians as $tech)
                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary fs-6">Assign</button>
                    <button type="button" class="btn btn-sm btn-secondary fs-6" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
