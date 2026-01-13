@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-header', 'Dashboard')

@section('css_after')
    <!-- Only include Datatables if you actually use tables on this page. If not, remove it to speed up load. -->
    <!-- <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" /> -->

    <style>
        /* Clean spacing for the chart container */
        .chart-outer-container {
            position: relative;
            width: 100%;
            /* Height control for mobile vs desktop */
            height: 300px;
        }

        @media (min-width: 992px) {
            .chart-outer-container {
                height: 350px;
            }
        }

        /* Specific override for the Pie chart to keep it compact */
        #complaintChartWrapper {
            height: 250px;
        }

        /* Increase font size for the stat-big class */
        .stat-big {
            font-size: 50px; /* Adjust this value as needed */
            line-height: 1; /* Adjust line height if necessary */
        }

        /* Adjust the height of the feedback chart container */
        .chart-outer-container {
            position: relative;
            width: 100%;
            height: 200px; /* Adjust this value to make the chart smaller */
        }

        @media (min-width: 992px) {
            .chart-outer-container {
                height: 250px; /* Adjust for larger screens */
            }
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Ensure Metronic Plugins are loaded -->
    <!-- <script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script> -->

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get Laravel data safely
        const complaintData = {!! json_encode($complaintData ?? []) !!};
        const feedbackData = {!! json_encode($feedbackData ?? []) !!};

        // ===============================
        //   METRONIC COLORS
        // ===============================
        const _getCssVar = (name, fallback) => {
            const computed = getComputedStyle(document.documentElement).getPropertyValue(name);
            return (computed && computed.trim() !== '') ? computed.trim() : fallback;
        };

        const primaryColor = _getCssVar('--kt-primary', '#3699FF');
        const dangerColor  = _getCssVar('--kt-danger', '#F64E60');
        const successColor = _getCssVar('--kt-success', '#1BC5BD');
        const warningColor = _getCssVar('--kt-warning', '#FFA800');
        const infoColor    = _getCssVar('--kt-info', '#50CD89');

        // =======================================================
        //  PIE CHART (Complaint Summary)
        // =======================================================
        const complaintCanvas = document.getElementById('complaintSummaryChart');

        if(complaintCanvas) {
            const complaintCtx = complaintCanvas.getContext('2d');
            const complaintLabels = complaintData.map(item => item.category);
            const complaintValues = complaintData.map(item => item.value);

            // Dynamic Colors
            const complaintColors = complaintData.map(item => {
                const cat = (item.category || '').toString().toLowerCase();
                if (cat.includes('completed')) return successColor;
                if (cat.includes('pending')) return warningColor;
                if (cat.includes('cancel')) return dangerColor;
                return infoColor;
            });

            new Chart(complaintCtx, {
                type: 'doughnut', // Doughnut looks cleaner than Pie on dashboards
                data: {
                    labels: complaintLabels,
                    datasets: [{
                        data: complaintValues,
                        backgroundColor: complaintColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // CRITICAL for responsiveness
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });
        }

        // =======================================================
        //  BAR CHART (Feedback & Ratings)
        // =======================================================
        const feedbackCanvas = document.getElementById('feedbackRatingsChart');

        if(feedbackCanvas) {
            const feedbackCtx = feedbackCanvas.getContext('2d');
            const feedbackLabels = feedbackData.map(item => item.rating);
            const feedbackCount = feedbackData.map(item => item.count);

            new Chart(feedbackCtx, {
                type: 'bar',
                data: {
                    labels: feedbackLabels,
                    datasets: [{
                        label: "Count",
                        data: feedbackCount,
                        backgroundColor: warningColor,
                        borderRadius: 4,
                        barThickness: 30, // Increase this value for wider bars
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // CRITICAL for responsiveness
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 2] } // Dashed grid lines
                        },
                        x: {
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false } // Hide legend for simple bar charts
                    }
                }
            });
        }
    });
    </script>
@endsection

@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <!-- Changed container-xxl to container-fluid for better mobile fit, or keep xxl but ensure no negative margins -->
            <div id="kt_content_container" class="container-xxl">

                <!--begin::Row (Charts)-->
                <div class="row g-5 gy-5">

                    <!-- Complaint Summary -->
                    <div class="col-12 col-lg-6">
                        <div class="card card-xl-stretch h-100">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 text-dark">Complaint Summary</span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">Overview of request statuses</span>
                                </h3>
                                <!-- Toolbar could go here -->
                            </div>
                            <a href="{{ route('technician.ticket.list') }}" class="card hoverable card-xl-stretch h-100">
                                <div class="card-body d-flex flex-center flex-column pt-0 px-0">
                                    <!-- Added wrapper for Chart.js sizing -->
                                    <div class="chart-outer-container" id="complaintChartWrapper">
                                        <canvas id="complaintSummaryChart"></canvas>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Feedback Summary -->
                    <div class="col-12 col-lg-6">
                        <div class="card card-xl-stretch h-100">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 text-dark">Feedback & Ratings Summary</span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">Student satisfaction levels</span>
                                </h3>
                            </div>
                            <a href="{{ route('feedback.index_technian') }}" class="card hoverable card-xl-stretch h-100">
                                <div class="card-body pt-0 px-5">
                                    <!-- Added wrapper for Chart.js sizing -->
                                    <div class="chart-outer-container">
                                        <canvas id="feedbackRatingsChart"></canvas>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <!--end::Row-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
@endsection
