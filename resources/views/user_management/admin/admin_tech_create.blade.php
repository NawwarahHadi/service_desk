@extends('layouts.app')

@section('title', 'Create Technician Account')

@section('page-header', 'User Management')

@section('css_after')
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
                                'STUDENT' => 'Student',
                                'TECHNICIAN' => 'Technician',
                                default => 'Role Not Set',
                            };
                        ?>

                        <!-- Role (Hidden, defaults to STUDENT) -->
                        <input type="hidden" name="role_id" value="3">

                        <!-- Role -->
                        <div class="col-md-6 mb-5">
                            <label for="role" class="form-label">Role</label>
                            <input type="text"
                                class="form-control"
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
                                class="form-control"
                                value="Active"
                                readonly
                                disabled>
                        </div>

                        <!-- Hostel (only for STUDENT role) -->
                        <div class="col-md-6 mb-5" id="hostel_field" style="display: none;">
                            <label for="hostel_id" class="form-label">Hostel</label>
                            <select class="form-select @error('hostel_id') is-invalid @enderror"
                                    id="hostel_id"
                                    name="hostel_id">
                                <option value="">Select Hostel (Optional)</option>
                                @if(isset($hostels) && $hostels->count() > 0)
                                    @foreach($hostels as $hostel)
                                        <option value="{{ $hostel->hostel_id }}" {{ old('hostel_id') == $hostel->hostel_id ? 'selected' : '' }}>
                                            {{ $hostel->name ?? 'Hostel #' . $hostel->hostel_id }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('hostel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional - Only applicable for students</div>
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
