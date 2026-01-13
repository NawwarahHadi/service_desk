@extends('layouts.app')

@section('title', 'Technician Ticket List')
@section('page-header', 'Technician Ticket List')

@section('css_after')
<link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('js_after')
<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{ asset('metronic/js/datatable.js')}}"></script>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Ticket List (Technician)</h3>
        </div>
        <div class="card-body">

            <table class="m-datatable table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                        <th>Ticket ID</th>
                        <th>Student ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Malfunction Date</th>
                        <th>Resolved Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody class="text-black-600 fw-semibold">
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->ticket_number }}</td>

                            <td>{{ $ticket->user->student_id ?? '-' }}</td>

                            <td>
                                <a href="{{ route('technician.ticket.details', $ticket->id) }}"
                                   class="fw-bold text-decoration-none text-dark">
                                    {{ $ticket->title }}
                                </a>
                                <div class="text-muted" style="font-size: 12px;">
                                    Location: {{ $ticket->location }}
                                </div>
                            </td>

                            <td>{{ $ticket->category->name ?? '-' }}</td>

                            <td>{{ $ticket->raised_date?->format('d/m/Y H:i') }}</td>

                            <td>
                                @if($ticket->status === 'completed' && $ticket->resolved_date)
                                    {{ $ticket->resolved_date->format('d/m/Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if ($ticket->status === 'completed')
                                    <span class="badge badge-light-success fs-6">Completed</span>
                                @elseif ($ticket->status === 'pending')
                                    <span class="badge badge-light-warning fs-6">Pending</span>
                                @elseif ($ticket->status === 'cancel')
                                    <span class="badge badge-light-danger fs-6">Cancel</span>
                                @else
                                    <span class="badge badge-light-secondary fs-6">Unknown</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('technician.ticket.update', $ticket->id) }}"
                                   class="btn btn-sm btn-info fs-6">
                                    Update
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
