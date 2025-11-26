@extends('layouts.app')

@section('title', 'User List')

@section('page-header', 'User Management')

@section('css_after')
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js_after')
<script>
    // Define the redirection URL
    const userListUrl = "{{ route('userlist') }}";
    // Note: The route helper 'route()' is a Laravel feature,
    // but we use it here because it's present in your HTML context.

    $(document).ready(function() {
        // 1. Target the form by its ID
        $('#create_user_form').on('submit', function(e) {

            // Prevent the default browser form submission (which would navigate away immediately)
            e.preventDefault();

            // *** IMPORTANT: In a real application, you would put the AJAX call
            // to the server here. The dialog/redirect would happen inside the
            // success callback of the AJAX request. ***

            // 2. Show the Success Dialog Box
            Swal.fire({
                title: 'Success!',
                text: 'User account created successfully.',
                icon: 'success', // Use 'success' for positive feedback
                confirmButtonText: 'Go to User List',
                // Remove cancel button as the action is finished
                showCancelButton: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                }
            }).then((result) => {
                // 3. Redirect after the user clicks the "Go to User List" button (or closes the alert)
                window.location.href = userListUrl;
            });

            // 4. If you wanted to automatically redirect without a click (e.g., after 2 seconds)
            /*
            setTimeout(function() {
                 window.location.href = userListUrl;
            }, 2000); // 2000 milliseconds = 2 seconds
            */
        });
    });
</script>
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card-header d-flex align-items-center justify-content-between">
    </div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title">Update User</h3>
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
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH') {{-- Or 'PUT' --}}

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <label for="userid" class="form-label required">UserID</label>
                        <input type="text"
                            class="form-control"
                            id="userid"
                            value="{{ $user->userid }}"
                            readonly />
                        <input type="hidden" name="userid" value="{{ $user->userid }}" />
                        @error('userid')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="student_id" class="form-label required">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="e.g. 123456"
                               value="{{ old('student_id', $user->student_id) }}" required>
                        @error('student_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <label for="name" class="form-label required">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@test.com"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <label for="is_active" class="form-label required">Status</label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="phone_num" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_num" name="phone_num" placeholder="e.g. 0123456789"
                               value="{{ old('phone_num', $user->phone_num) }}" required>
                        @error('phone_num')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="row">
                <div class="col-md-12 mb-5">
                        <label for="role_id" class="form-label required">Role</label>

                        <input type="text" class="form-control" value="{{ optional($user->role)->name ?? 'Student' }}" readonly>
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">

                        @error('role_id')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="separator separator-dashed my-8"></div>

                <h3 class="mb-5">Update Password (Optional)</h3>
                <p class="text-muted">Leave the password fields blank to keep the user's current password.</p>

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('userlist') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-info">
                        <i class="ki-duotone ki-check fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Update User
                    </button>
                    </div></div>
            </form>
        </div>
    </div>

@endsection
