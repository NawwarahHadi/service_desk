@extends('layouts.app')

@section('title', 'Create Student Account')

@section('page-header', 'User Management')

@section('css_after')
@endsection

@section('js_after')
    <script>
        $(document).ready(function() {
            // Show/hide hostel field based on role selection
            function toggleHostelField() {
                var role = $('#role').val();
                if (role === 'STUDENT') {
                    $('#hostel_field').show();
                    $('#hostel_id').prop('required', false); // Optional field
                } else {
                    $('#hostel_field').hide();
                    $('#hostel_id').val('').prop('required', false);
                }
            }

            // Initial state
            toggleHostelField();

            // On role change
            $('#role').on('change', function() {
                toggleHostelField();
            });
        });
    </script>
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">Create New User</h3>
                <div class="card-toolbar">
                    <a href="{{ route('userlist') }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Back to List
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.store') }}" id="create_user_form">
                    @csrf

                    <div class="row mb-5">
                        <!-- Name -->
                        <div class="col-md-6 mb-5">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-5">
                            <label for="email" class="form-label required">Email</label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Student ID -->
                        <div class="col-md-6 mb-5">
                            <label for="student_id" class="form-label required">USM ID</label>
                            <input type="text"
                                   class="form-control @error('student_id') is-invalid @enderror"
                                   id="student_id"
                                   name="student_id"
                                   value="{{ old('student_id') }}"
                                   required>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6 mb-5">
                            <label for="password" class="form-label required">Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="col-md-6 mb-5">
                            <label for="password_confirmation" class="form-label required">Confirm Password</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required>
                        </div>

                        <!-- Role (Hidden, defaults to STUDENT) -->
                        <input type="hidden" name="role_id" value="2">

                        <!-- Role Display (Read-only) -->
                        <div class="col-md-6 mb-5">
                            <label for="role_display" class="form-label">Role</label>
                            <input type="text"
                                class="form-control"
                                value="Student"
                                readonly
                                disabled>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6 mb-5">
                            <label for="phone_num" class="form-label">Phone Number</label>
                            <input type="text"
                                   class="form-control @error('phone_num') is-invalid @enderror"
                                   id="phone_num"
                                   name="phone_num"
                                   value="{{ old('phone_num') }}">
                            @error('phone_num')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status (Hidden, defaults to ACTIVE) -->
                        <input type="hidden" name="status" value="ACTIVE">

                        <!-- Status Display (Read-only) -->
                        <div class="col-md-6 mb-5">
                            <label for="status_display" class="form-label">Status</label>
                            <input type="text"
                                class="form-control"
                                value="Active"
                                readonly
                                disabled>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('userlist') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-info">
                            <i class="ki-duotone ki-check fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
