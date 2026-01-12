@extends('layouts.app')

@section('title', 'Create Ticket')

@section('page-header',  'Create Ticket')


@section('css_after')
@endsection

<script>
    window.ticketListUrl = "{{ route('complaint.ticket.list') }}";
</script>

<script src="{{ asset('js/complaintmodule/create.js') }}"></script>


@section('js_after')
    {{-- <script src="{{ asset('metronic/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/js/scripts.bundle.js') }}"></script> --}}
    <script src="{{ asset ('metronic/js/button_loading.js')}}"></script>
    <script src="{{ asset ('metronic/js/createticket.js')}}"></script>
@endsection

@section('content')
<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid">
                <!-- Ticket Form -->
                <div class="d-flex justify-content-center align-items-center min-vh-100">
                    <div class="card shadow-sm" style="max-width: 800px; width:100%">
                        <div class="card-body p-12">
                            <form id="kt_modal_new_ticket_form" class="form" method="POST" action="{{ route('complaint.ticket.store') }}"> @csrf
                                <!-- Heading -->
                                <div class="mb-13 text-center">
                                    <h1 class="mb-3">Create Ticket</h1>
                                </div>

                                <!-- Title -->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Title</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Enter your ticket title" name="title" />
                                </div>

                                <!-- Product and Assign -->
                                <div class="row g-9 mb-8">
                                    <div class="col-12 fv-row">
                                        <label class="required fs-6 fw-semibold mb-2">Category</label>
                                        <select class="form-select form-select-solid" name="category_id">
                                            <option value="">Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <!-- Description -->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Description</label>
                                    <textarea class="form-control form-control-solid" rows="4" name="description" placeholder="Type your ticket description"></textarea>
                                </div>

                                <!-- Location -->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                        <span class="required">Location</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" placeholder="Enter your location" name="location" />
                                </div>

                                <!-- Date  Service Not Function-->
                                <div class="row g-9 mb-8">
                                    <div class="col-12 fv-row">
                                    <label class="required fs-6 fw-semibold mb-2">Malfunction Date</label>
                                    <input class="form-control form-control-solid" placeholder="Select a date" name="raised_date" type="date" />
                                    </div>
                                </div>


                                <!--begin::Actions-->
                                <div class="text-center">
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="reset" id="kt_modal_new_ticket_cancel" class="btn btn-light me-3">Cancel</button>
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
                                <!--end::Actions-->
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</body>
@endsection
