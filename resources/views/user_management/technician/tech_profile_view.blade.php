@extends('layouts.app')

@section('title', 'Technician Profile')

@section('page-header',  'My Profile')

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">Technician Profile</h3>
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

                <form action="{{ route('technician.profile.update') }}" method="POST" class="row g-5">
                    @csrf
                    @method('PATCH')

                    {{-- <div class="col-md-6">
                        <label class="form-label">User ID</label>
                        <input type="text" class="form-control" value="{{ $user->userid }}" readonly>
                    </div> --}}

                    <div class="col-md-12">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ optional($user->role)->name ?? 'Technician' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="student_id" class="form-label required">USM ID</label>
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

                    <div class="col-md-6">
                        <label for="phone_num" class="form-label">Phone Number</label>
                        <input type="text"
                               id="phone_num"
                               name="phone_num"
                               class="form-control @error('phone_num') is-invalid @enderror"
                               value="{{ old('phone_num', $user->phone_num) }}">
                        @error('phone_num')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Leave blank to keep your current password.</small>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control"
                               autocomplete="new-password">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Assigned Skills / Categories</label>
                        <div class="p-3 bg-light rounded border">
                            @if($user->categories && $user->categories->count() > 0)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($user->categories as $category)
                                        <span class="badge badge-info fs-6">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted small fst-italic">
                                    No specific maintenance categories assigned yet.
                                </span>
                            @endif
                        </div>
                        <div class="form-text text-muted mt-1">
                            These are assigned by the Administrator based on your expertise.
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-info">
                            <i class="ki-duotone ki-check fs-2"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
