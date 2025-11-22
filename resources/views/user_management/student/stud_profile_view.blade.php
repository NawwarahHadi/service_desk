@extends('layouts.app')

@section('title', 'Student Profile')

@section('page-header',  'My Profile')

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">Student Profile</h3>
                <div class="card-toolbar">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light">
                        <i class="ki-duotone ki-arrow-left fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('student.profile.update') }}" method="POST" class="row g-5">
                    @csrf
                    @method('PATCH')

                    <div class="col-md-6">
                        <label class="form-label">User ID</label>
                        <input type="text" class="form-control" value="{{ $user->userid }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="student_id" class="form-label required">Student ID</label>
                        <input type="text"
                               id="student_id"
                               name="student_id"
                               class="form-control @error('student_id') is-invalid @enderror"
                               value="{{ old('student_id', $user->student_id) }}"
                               required>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="name" class="form-label required">Full Name</label>
                        <input type="text"
                               id="name"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email"
                               id="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="is_active" class="form-label required">Status</label>
                        <select class="form-select" id="is_active" name="is_active" disabled>
                            <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone_num" class="form-label">Phone Number</label>
                        <input type="text"
                               id="phone_num"
                               name="phone_num"
                               placeholder="eg: 0123456789"
                               class="form-control @error('phone_num') is-invalid @enderror"
                               value="{{ old('phone_num', $user->phone_num) }}">
                        @error('phone_num')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ optional($user->role)->name ?? 'Student' }}" readonly>
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}">
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

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-info">
                            <i class="ki-duotone ki-check fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
