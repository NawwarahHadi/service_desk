@extends('layouts.app')

@section('title', 'User List')

@section('page-header', 'User Management')

@section('css_after')
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
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
                        <label for="name" class="form-label required">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@test.com"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-5">
                        <label for="role_id" class="form-label required">Role</label>
                        <select class="form-select" id="role_id" disabled>
                            <option value="">Select a Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="role_id" value="{{ $user->role_id }}" />
                        @error('role_id')
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

                <div class="text-end">
                    <button type="submit" class="btn btn-info">
                        <i class="ki-duotone ki-check fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
