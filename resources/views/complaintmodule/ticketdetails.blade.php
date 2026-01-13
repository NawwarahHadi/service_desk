@extends('layouts.app')

@section('title', 'Ticket Details')

@section('page-header',  'Ticket Details')


@section('css_after')
@endsection

@section('content')
<body>
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
                    <h6 class="fw-semibold text-muted mb-1">Title</h6>
                    <p class="fs-6 mb-0">{{ $ticket->title }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold text-muted mb-1">Category</h6>
                    <p class="fs-6 mb-0">{{ $ticket->category->name }}</p>
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
                    <h6 class="fw-semibold text-muted mb-1">Malfunction Date</h6>
                    <p class="fs-6 mb-0">{{ \Carbon\Carbon::parse($ticket->raised_date)->format('d/m/Y H:i') }}</p>
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
                        @if ($ticket->status == 'completed')
                            <span class="badge bg-success text-white fs-6" >Completed</span>
                        @elseif ($ticket->status == 'pending')
                            <span class="badge bg-warning text-white fs-6">Pending</span>
                        @elseif ($ticket->status == 'cancel')
                            <span class="badge bg-danger text-white fs-6">Cancel</span>
                        @endif
                </div>

                <div class="mb-4">
                    @if (!empty($ticket->technician_comment))
                        <h6 class="fw-semibold text-muted mb-1">Comment</h6>
                        @if ($ticket->status == 'completed')
                            <p class="fs-6 mb-0 bg-success-subtle p-3 rounded w-100" style="min-height: 60px;">
                                {{ $ticket->technician_comment }}
                            </p>
                        @elseif ($ticket->status == 'cancel')
                            <p class="fs-6 mb-0 bg-danger-subtle p-3 rounded w-100" style="min-height: 60px;">
                                {{ $ticket->technician_comment }}
                            </p>
                        @endif
                    @endif
                </div>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('complaint.ticket.list') }}" class="btn btn-sm btn-info fs-6">Back</a>
                 {{-- <a href="#"
                    class="btn btn-primary {{ $ticket->status != 'Completed' ? 'd-none' : '' }}">
                    Feedback
                </a> --}}
            </div>
        </div>
    </div>
</body>
@endsection
