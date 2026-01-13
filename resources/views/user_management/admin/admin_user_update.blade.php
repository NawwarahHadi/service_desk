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
                @method('PATCH')

                <div class="row">
                    <div class="col-md-12 mb-5">
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
                        <label for="student_id" class="form-label required">USM ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" placeholder="USM ID"
                               value="{{ old('student_id', $user->student_id) }}" required>
                        @error('student_id')
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

                {{-- ... Previous Code ... --}}

                {{-- NEW SECTION: SKILLS / CATEGORIES (Only visible for Technicians) --}}
                @php
                    $isTechnician = ($user->role_id == 3) || (optional($user->role)->name == 'technician');
                @endphp

                @if($isTechnician)
                    <div class="separator separator-dashed my-8"></div>

                    {{-- ✅ FIX: Added 'row' and 'col-12' to fix the left margin alignment --}}
                    <div class="row">
                        <div class="col-12 mb-10">
                            <label class="form-label fw-bold fs-6 mb-2">Assign Skills (Categories)</label>
                            <div class="text-muted fs-7 mb-4">
                                Select the maintenance categories this technician is responsible for.
                            </div>

                            <div class="row g-3">
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $category)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       value="{{ $category->id }}"
                                                       id="cat_{{ $category->id }}"
                                                       name="categories[]"
                                                       {{ $user->categories->contains($category->id) ? 'checked' : '' }}
                                                />
                                                <label class="form-check-label" for="cat_{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-warning">
                                        No categories found in database.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- <div class="separator separator-dashed my-8"></div>

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
                </div> --}}

                <div class="text-end">
                    <button type="submit" class="btn btn-info">
                        <i class="ki-duotone ki-check fs-2"></i>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
