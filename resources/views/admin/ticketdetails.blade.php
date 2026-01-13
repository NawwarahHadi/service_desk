@extends('layouts.app')

@section('title', 'Admin Ticket Details')
@section('page-header', 'Ticket Details')

@section('js_after')
<script>
    // Pass technicians from PHP to JS
    const allTechnicians = {!! json_encode($technicians) !!};

    document.addEventListener('DOMContentLoaded', function () {
        const assignBtn = document.getElementById('assignBtn');
        if (!assignBtn) return;

        assignBtn.addEventListener('click', function () {
            const categoryId = Number(this.dataset.categoryId);
            const technicianSelect = document.getElementById('technician');
            const submitBtn = document.querySelector('#assignModal button[type="submit"]');

            technicianSelect.innerHTML = '';

            const matchingTechnicians = allTechnicians.filter(tech =>
                tech.categories.some(cat => Number(cat.id) === categoryId)
            );

            if (matchingTechnicians.length === 0) {
                technicianSelect.innerHTML =
                    '<option value="">No technician available for this category</option>';
                submitBtn.disabled = true;
            } else {
                matchingTechnicians.forEach(tech => {
                    const option = document.createElement('option');
                    option.value = tech.id;
                    option.textContent = tech.name;
                    technicianSelect.appendChild(option);
                });
                submitBtn.disabled = false;
            }
        });
    });
</script>
@endsection

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm" style="width: 80%;">
        <div class="card-header">
            <h3 class="card-title mb-0">Ticket Details</h3>
        </div>

        <div class="card-body">
            @php
                $fields = [
                    'Ticket Number' => $ticket->ticket_number,
                    'Student ID' => $ticket->user->student_id ?? '-',
                    'Title' => $ticket->title,
                    'Category' => $ticket->category->name ?? '-',
                    'Description' => $ticket->description,
                    'Location' => $ticket->location,
                    'Date Raised' => optional($ticket->raised_date)->format('d/m/Y') ?? '-',
                    'Resolved Date' => optional($ticket->resolved_date)->format('d/m/Y') ?? '-',
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
                @if ($ticket->status === 'completed')
                    <span class="badge badge-light-success fs-6">Completed</span>
                @elseif ($ticket->status === 'pending')
                    <span class="badge badge-light-warning fs-6">Pending</span>
                @elseif ($ticket->status === 'cancel')
                    <span class="badge badge-light-danger fs-6">Cancel</span>
                @else
                    <span class="badge badge-light-secondary fs-6">Unknown</span>
                @endif
            </div>

            {{-- Comment --}}
            @if (!empty($ticket->comment))
                <div class="mb-4">
                    <h6 class="fw-semibold text-muted mb-1">Comment</h6>
                    <p class="fs-6 mb-0 p-3 rounded
                        {{ $ticket->status === 'completed' ? 'bg-success-subtle' : 'bg-danger-subtle' }}">
                        {{ $ticket->comment }}
                    </p>
                </div>
            @endif
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.ticket.list') }}" class="btn btn-sm btn-info">Back</a>

            @if($ticket->status === 'pending')
                <button
                    id="assignBtn"
                    class="btn btn-sm btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#assignModal"
                    data-category-id="{{ $ticket->category_id }}">
                    Assign Technician
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Assign Technician Modal --}}
@if($ticket->status === 'pending')
<div class="modal fade" id="assignModal" tabindex="-1">
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
                    <label class="form-label">Choose Technician</label>
                    <select name="technician_id" id="technician" class="form-select" required></select>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Assign</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
