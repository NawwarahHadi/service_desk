@extends('layouts.app')

@section('title', 'Ticket List')

@section('page-header',  'Ticket List')


@section('css_after')
    <link href="{{ asset ('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('js_after')
    <script src="{{ asset ('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{ asset ('metronic/js/datatable.js')}}"></script>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">History of Ticket List</h3>
            <div class="card-toolbar">
                <a href=/complaint/createticket class="btn btn-sm btn-info fs-6">
                    <i class="ki-duotone ki-plus-square">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Create Ticket
                </a>
            </div>
        </div>
        <div class="card-body">
            <style>
                /* Active page number button (currently blue) → make it purple */
                .page-item.active .page-link {
                    background-color: #7239EA !important; /* Purple */
                    border-color: #7239EA !important;
                    color: #fff !important;
                }

                /* Normal page number buttons (optional, if you also want purple border on hover/normal) */
                .page-link {
                    color: #7239EA !important;
                }

                .page-link:hover {
                    background-color: #ebe0ff !important; /* light purple hover */
                    color: #7239EA !important;
                }
            </style>
            <table class="m-datatable table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                        <th>Ticket Number</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Malfunction Date</th>
                        <th class="text-start">Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-black-600 fw-semibold">
                    @foreach ($tickets as $ticket)
                        <tr onclick="window.location='{{ route('complaint.ticket.details', $ticket->ticket_number) }}';" style="cursor:pointer;">
                            <td>{{ $ticket->ticket_number }}</td>

                            <!-- Title + Location in the same cell -->
                            <td>
                                <div class="fw-bold">{{ $ticket->title }}</div>
                                <div class="text-muted" style="font-size: 12px;">Location: {{ $ticket->location }}</div>
                            </td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($ticket->raised_date)->format('d/m/Y') }}</td>

                            <!-- Status aligned left -->
                            <td class="text-start">
                                @if ($ticket->status == 'completed')
                                    <span class="badge badge-light-success fs-6">Completed</span>
                                @elseif ($ticket->status == 'pending')
                                    <span class="badge badge-light-warning fs-6">Pending</span>
                                @elseif ($ticket->status == 'cancel')
                                    <span class="badge badge-light-danger fs-6">Cancel</span>
                                @else
                                    <span class="badge badge-light-secondary fs-6">Unknown</span>
                                @endif
                            </td>

                            <td style="vertical-align: middle; text-align:left;">
                                @if ($ticket->status == 'Completed')
                                    @if (!empty($ticket->rating) && $ticket->rating > 0)
                                        {{-- ⭐ Show stars when rating exists --}}
                                        <div class="rating d-flex justify-content-left" style="gap:4px;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="rating-label {{ $i <= $ticket->rating ? 'checked' : '' }}">
                                                    <i class="ki-duotone ki-star fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            @endfor
                                        </div>
                                    @else
                                        {{-- ❗ No rating yet → show Rate button --}}
                                        <a href="{{ route('feedback.create', $ticket->ticket_number) }}"
                                        class="btn btn-sm btn-info fs-6"
                                        onclick="event.stopPropagation();">
                                            {{-- <i class="ki-duotone ki-star fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i> --}}
                                            Rate
                                        </a>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
