@extends('layouts.app')

@section('title', 'Update Ticket')
@section('page-header', 'Update Ticket')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm" style="width: 80%;">
        <div class="card-header">
            <h3 class="card-title">Update Ticket: {{ $ticket->title }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('technician.ticket.update.submit', $ticket->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" value="{{ $ticket->title }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" class="form-control" value="{{ $ticket->category->name ?? '-' }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" disabled>{{ $ticket->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" value="{{ $ticket->location }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ strtolower($ticket->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ strtolower($ticket->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancel" {{ strtolower($ticket->status) === 'cancel' ? 'selected' : '' }}>Cancel</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Add Notes (optional)</label>
                    <textarea name="notes" class="form-control" rows="3">{{ $ticket->notes ?? '' }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('technician.ticket.list') }}" class="btn btn-light me-3">Cancel</a>
                    <button type="submit" class="btn btn-sm btn-info fs-6">Update Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
