@extends('layouts.app')

@section('title', 'Feedback')

@section('page-header',  'Feedback')


@section('css_after')
    <link href="{{ asset ('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <style>
        /* Active page number button (currently blue) → make it purple */
        .page-item.active .page-link {
            background-color: #6f42c1 !important; /* Purple */
            border-color: #6f42c1 !important;
            color: #fff !important;
        }

        /* Normal page number buttons (optional, if you also want purple border on hover/normal) */
        .page-link {
            color: #6f42c1 !important;
        }

        .page-link:hover {
            background-color: #ebe0ff !important; /* light purple hover */
            color: #6f42c1 !important;
        }
    </style>

@endsection

@section('js_after')
    <script src="{{ asset ('metronic/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{ asset ('metronic/js/datatable.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var table = $('#feedbackTable').DataTable();
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selected = $('#ratingFilter').val();
                    var rating = $(table.row(dataIndex).node()).find('td[data-rating]').data('rating');

                    if (selected === "all" || selected == rating) {
                        return true;
                    }
                    return false;
                }
            );
            $('#ratingFilter').on('change', function () {
                table.draw();
            });
        });
    </script>
@endsection

@section('content')
<div id="kt_content_container" class="container-xxl">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Feedback</h3>
            <div class="card-toolbar d-flex align-items-center">
                <select id="ratingFilter" class="form-select form-select-solid w-150px ms-3"data-control="select2" data-hide-search="true" data-placeholder="Rating">
                    <option value="all">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <table id="feedbackTable" class="m-datatable table align-middle table-row-dashed fs-6 gy-5">
                <thead>
                    <tr class="text-dark fw-bold fs-7 text-uppercase gs-0">
                        <th style="width:10%; text-align:left;">Ticket ID</th>
                        <th style="width:10%; text-align:left;">Student ID</th>
                        <th style="width:10%; text-align:left;">Student Name</th>
                        <th style="width:15%; text-align:left;">Title</th>
                        <th style="width:20%; text-align:left;">Technician Name</th>
                        <th style="width:15%; text-align:leftcenter;">Rating</th>
                        <th style="width:45%; text-align:left;">Comment</th>
                    </tr>
                </thead>

               <tbody class="text-black-600 fw-semibold">
                    @foreach($feedback as $feedbacks)
                        <tr>

                            <td style="vertical-align: middle; text-align:left;">
                                {{ $feedbacks->ticket_id }}
                            </td>

                            <td style="vertical-align: middle; text-align:left;">
                                {{ $feedbacks->student->student_id }}
                            </td>

                            <td style="vertical-align: middle; text-align:left;">
                                {{$feedbacks->student->name }}
                            </td>

                            <td style="vertical-align: middle; text-align:left;">
                                {{  $feedbacks->ticket->title }}
                            </td>

                            <td style="vertical-align: middle; text-align:left;">
                                {{ $feedbacks->ticket->technician->name }}
                            </td>

                            <td style="vertical-align: middle; text-align:left;" data-rating="{{ $feedbacks->rating }}">
                                <div class="rating d-flex justify-content-left" style="gap:4px;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="rating-label {{ $i <= $feedbacks->rating ? 'checked' : '' }}">
                                            <i class="ki-duotone ki-star fs-2"></i>
                                        </div>
                                    @endfor
                                </div>
                            </td>

                            <td style="vertical-align: middle; text-align:left;">
                                {{ $feedbacks->comment }}
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>

@endsection

