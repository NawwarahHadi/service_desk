@extends('layouts.app')

@section('title', 'Create Feedback')

@section('page-header', 'Create Feedback : ' . $ticket->title)


@section('css_after')
    <link href="{{ asset ('metronic/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('js_after')
    <script src="{{ asset ('metronic/js/button_loading.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll("#ratingStars i");
            const ratingValue = document.getElementById("ratingValue");
            const ratingLabel = document.getElementById("ratingLabel");

            stars.forEach(star => {
                // Hover effect
                star.addEventListener("mouseover", function () {
                    resetStars();
                    highlightStars(this.dataset.rating);
                });

                // Select star
                star.addEventListener("click", function () {
                    ratingValue.value = this.dataset.rating;
                    // ratingLabel.innerHTML = "You selected " + this.dataset.rating + " star(s)";
                    persistStars(this.dataset.rating);
                });

                // Remove hover, keep selected
                star.addEventListener("mouseleave", function () {
                    persistStars(ratingValue.value);
                });
            });

            // Helper Functions
            function highlightStars(limit) {
                stars.forEach(star => {
                    if (star.dataset.rating <= limit) {
                        star.classList.add("text-warning");
                    }
                });
            }

            function resetStars() {
                stars.forEach(star => star.classList.remove("text-warning"));
            }

            function persistStars(limit) {
                resetStars();
                if (!limit) return;
                highlightStars(limit);
            }
        });
    </script>

    <script>
        document.getElementById("cancelBtn").addEventListener("click", function () {

            Swal.fire({
                title: "Cancel Feedback?",
                text: "Are you sure? Your changes will not be saved.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, cancel",
                cancelButtonText: "Return",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('complaint.ticket.list') }}";
                }
            });

        });
    </script>


@endsection



@section('content')
<div id="kt_content_container" class="container-xxl d-flex justify-content-center">

    <div class="card mb-5 mb-xl-10" style="max-width: 650px; width:100%; margin-top:40px;">

        <!-- Header -->
        <div class="card-header border-0 text-center pt-10">
            <div class="card-title m-0 w-100 d-flex flex-column align-items-center">
                <h3 class="fw-bold m-0 fs-1">We'd Love Your Feedback</h3>
            </div>
        </div>

        <!-- Form -->
        <form method="post" action="{{ route('feedback.save') }}">
            @csrf
            <div class="card-body pt-5 pb-8">
                <p class="text-muted fs-5 mb-10 text-center">
                    Help us improve your experience
                </p>
                <!-- Rating -->
                <div class="mb-10">
                    <label class="fs-4 fw-bold mb-4 d-block text-center required">
                        How would you rate your experience?
                    </label>

                    <div class="d-flex justify-content-center gap-2 mb-2 rating-stars" id="ratingStars">
                        <i class="ki-duotone ki-star fs-2 cursor-pointer" data-rating="1"></i>
                        <i class="ki-duotone ki-star fs-2 cursor-pointer" data-rating="2"></i>
                        <i class="ki-duotone ki-star fs-2 cursor-pointer" data-rating="3"></i>
                        <i class="ki-duotone ki-star fs-2 cursor-pointer" data-rating="4"></i>
                        <i class="ki-duotone ki-star fs-2 cursor-pointer" data-rating="5"></i>
                    </div>

                    <div class="fw-semibold rating-label text-center" id="ratingLabel"></div>
                    <input type="hidden" name="rating" id="ratingValue">
                </div>

                <div class="mb-8">
                    <label class="fs-5 fw-bold mb-3 required d-block text-center">
                        Share Your Thoughts
                    </label>

                    <div class="d-flex justify-content-center">
                        <div style="max-width: 550px; width: 100%;">
                            <textarea  class="form-control form-control-solid"rows="6" name="comment" id="comment" placeholder="Tell us more about your experience. What did we do well? What could we improve?"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <input type="hidden" name="technician_id" value="{{ $ticket->assigned_id_technician }}">

            <div class="text-center">
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="button" class="btn btn-light me-3" id="cancelBtn">
                        Cancel
                    </button>
                    <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-info button-loading">
                        <i class="ki-duotone ki-send">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span class="indicator-label">
                            Submit
                        </span>
                        <span class="indicator-progress">
                            Please wait <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </form>

    </div>

</div>
@endsection

