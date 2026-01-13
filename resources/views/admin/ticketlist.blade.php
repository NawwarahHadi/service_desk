@extends('layouts.app')

@section('title', 'Admin Ticket List')
@section('page-header', 'Admin Ticket List')

@section('css_after')
<link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('js_after')
<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('metronic/js/datatable.js') }}"></script>

<script>
// Pass technicians data from PHP to JS
const allTechnicians = {!! json_encode($technicians) !!};

document.addEventListener('DOMContentLoaded', function () {
    // Use delegated event listener for DataTables compatibility
    document.querySelector('table').addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-assign')) {
            const ticketId = e.target.dataset.ticket;
            const status = e.target.dataset.status;
            const categoryId = Number(e.target.dataset.categoryId); // ✅ ensure numeric

            if (status.toLowerCase() !== 'pending') return;

            // Set ticket ID in modal
            document.getElementById('assignTicketId').value = ticketId;

            const technicianSelect = document.getElementById('technician');
            technicianSelect.innerHTML = '';

            // Debugging logs (optional)
            console.log('CATEGORY ID FROM BUTTON:', categoryId);
            console.log('ALL TECHNICIANS:', allTechnicians);

            // Filter technicians by category ID
            const matchingTechnicians = allTechnicians.filter(tech =>
                tech.categories.some(cat => Number(cat.id) === categoryId)
            );

            const submitBtn = document.querySelector('#assignModal button[type="submit"]');

            if (matchingTechnicians.length === 0) {
                technicianSelect.innerHTML = '<option value="">No technician available for this category</option>';
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

            // Show modal
            new bootstrap.Modal(document.getElementById('assignModal')).show();
        }
    });
});
</script>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Ticket List (Admin)</h3>
        </div>

        <div class="card-body">
            <table class="m-datatable table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                        <th>Ticket Number</th>
                        <th>Student ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Technician</th>
                        <th>Date</th>
                        <th>Resolved Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="fw-semibold">
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->user->userid ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.ticket.details', $ticket->id) }}" class="fw-bold text-decoration-none text-dark">
                                    {{ $ticket->title }}
                                </a>
                                <div class="text-muted fs-7">
                                    Location: {{ $ticket->location }}
                                </div>
                            </td>
                            <td>{{ $ticket->category->name ?? '-' }}</td>
                            <td>{{ $ticket->technician->name ?? 'Not Assigned' }}</td>
                            <td>{{ optional($ticket->raised_date)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ optional($ticket->resolved_date)->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                @if ($ticket->status === 'completed')
                                    <span class="badge badge-light-success">Completed</span>
                                @elseif ($ticket->status === 'pending')
                                    <span class="badge badge-light-warning">Pending</span>
                                @elseif ($ticket->status === 'cancel')
                                    <span class="badge badge-light-danger">Cancel</span>
                                @else
                                    <span class="badge badge-light-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-info btn-assign {{ strtolower($ticket->status) !== 'pending' ? 'disabled' : '' }}"
                                    data-ticket="{{ $ticket->id }}"
                                    data-status="{{ $ticket->status }}"
                                    data-category-id="{{ $ticket->category_id }}">
                                    Assign
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Assign Technician Modal -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.assign.technician') }}">
            @csrf
            <input type="hidden" id="assignTicketId" name="ticket_id">

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
                    <button type="submit" class="btn btn-info btn-sm">Assign</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
