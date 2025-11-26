@extends('layouts.app')

@section('title', 'Create Technician Account')

@section('page-header', 'User Management')

@section('css_after')
@endsection

@section('js_after')
<script>
    // Assuming SweetAlert2 (Swal) and jQuery are loaded globally.

    // 1. Intercept the form submission
    $('#create_user_form').on('submit', function(e) {
        // Prevent the default form submission for initial validation/setup
        // You only need this if you want to skip the backend entirely for demo purposes,
        // but typically you let the backend handle the submission first.

        // **IMPORTANT CONCEPT:**
        // In a real application, the PHP/Laravel backend handles the form submission
        // (to route('admin.users.store')). If successful, the backend does one of two things:
        // A. Returns a JSON success message (for AJAX forms).
        // B. Redirects back to '/userlist' with a session flash message.

        // Since you are focusing on the frontend *after* creation:
        // We will simulate the success scenario that happens *after* the backend finishes.

        // --- SIMULATING BACKEND SUCCESS AND REDIRECTION ---

        // This is a placeholder for the logic that happens after the backend saves the user.
        // If your backend redirects with a session flash message (e.g., 'success'),
        // you would check for that session data here and display the Swal.

        // For a pure frontend simulation, we'll stop the form submission and display the success dialog:

        // **If you want the dialog to appear right after clicking 'Create User' (before backend processing):**
        // e.preventDefault();
        // Swal.fire({ ... }).then(() => { if (result.isConfirmed) { this.submit(); } });
        // **But since you asked to redirect to /userlist *after* creation,
        // we'll simulate the dialog appearing on the /userlist page after the backend redirects.**
    });


    // 2. Logic to display the success dialog on the destination page (/userlist)
    //    Since you want the dialog to show *after* the user is created and the page redirects
    //    to /userlist, you typically put this code on the /userlist page, which checks for a
    //    session success message from the backend.

    // **Alternative (Pure Frontend Simulation):**
    // We will change the form action to redirect to /userlist and add a parameter
    // that the /userlist page can check for.

    // --- TEMPORARY PURE FRONTEND CODE (FOR SIMULATION ON THE CURRENT PAGE) ---
    // This function will execute immediately upon page load (e.g., if the user was just created and redirected)

    // Note: For this to work seamlessly, you would typically need to redirect
    // back to this page with a URL parameter or a session flash message.

    const showSuccessDialog = (message) => {
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: 'success',
            confirmButtonText: 'View Users',
            customClass: {
                confirmButton: "btn btn-success",
            }
        }).then((result) => {
            // Optional: Redirect to /userlist if the user clicks the confirm button
            if (result.isConfirmed) {
                 window.location.href = "{{ route('userlist') }}";
            }
        });
    }

    // Since we can't fully control the backend redirect here, we'll bind the
    // success dialog to the successful form submission using an **AJAX simulation** // for a better frontend experience:

    $('#create_user_form').on('submit', function(e) {
        e.preventDefault(); // Stop the default browser form submission

        const form = $(this);

        // In a real app, you'd perform an AJAX call here (e.g., $.post, fetch)
        // Since we are frontend-only, we SIMULATE a successful response after a short delay

        // Add a loading state
        form.find('button[type="submit"]').prop('disabled', true).html('Creating...');

        setTimeout(() => {
            // --- SIMULATED SUCCESS RESPONSE ---

            // 1. Show the success dialog
            showSuccessDialog('New user account created successfully!');

            // 2. The redirection is handled inside the showSuccessDialog function's .then() block

            // --- END SIMULATION ---

        }, 500); // Simulate network delay (500ms)

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
                <!-- UserID Display (Auto-generated) -->
                <div class="alert alert-info mb-5">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note:</strong> UserID will be automatically generated when the technician account is created.
                </div>

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

                        <!-- Staff ID -->
                        <div class="col-md-6 mb-5">
                            <label for="staff_id" class="form-label required">Staff ID</label>
                            <input type="text"
                                class="form-control @error('staff_id') is-invalid @enderror"
                                   id="staff_id"
                                   name="staff_id"
                                   value="{{ old('staff_id') }}"
                                   required>
                            @error('staff_id')
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

                        <?php
                            // Get the role from the old input (on validation failure) or the URL query parameter 'role'
                            $selectedRole = old('role', request()->query('role'));

                            // Define display text based on the value (for the visible field)
                            $roleDisplay = match (strtoupper($selectedRole)) {
                                'TECHNICIAN' => 'Technician',
                                default => 'Technician',
                            };
                        ?>
                        <!-- Role (Hidden, defaults to TECHNICIAN) -->
                        <input type="hidden" name="role" value="technician">

                        <!-- Role Display (Read-only) -->
                        <div class="col-md-6 mb-5">
                            <label for="role_display" class="form-label">Role</label>
                            <input type="text"
                                class="form-control bg-light"
                                value="Technician"
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
                                class="form-control bg-light"
                                value="Active"
                                readonly
                                disabled>
                            <div class="form-text text-muted">New users are automatically set to Active status</div>
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
