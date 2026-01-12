@extends('layouts.app')

@section('title', 'User Management')

@section('page-header', 'User Management')

@section('css_after')
    <link href="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js_after')
    <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('metronic/js/datatable.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#users-table').DataTable({
                responsive: true,
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ],
                dom: 'rtip',
            });

            // SEARCH
            var searchInput = $('input[data-kt-user-table-filter="search"]');
            var searchTimeout;

            searchInput.on('keyup', function() {
                clearTimeout(searchTimeout);
                var value = $(this).val();
                searchTimeout = setTimeout(function() {
                    table.search(value).draw();
                }, 300);
            });

            // EXPORT
            $('#export-btn').on('click', function() {
                var searchValue = searchInput.val();
                var roleFilter = new URLSearchParams(window.location.search).get('role');

                var exportUrl = '{{ route("admin.users.export") }}';
                var params = new URLSearchParams();

                if (searchValue) params.append('search', searchValue);
                if (roleFilter) params.append('role', roleFilter);

                if (params.toString()) exportUrl += '?' + params.toString();

                window.location.href = exportUrl;
            });

            // DELETE CONFIRMATION
            $(document).on('click', '.delete-data', function(e){
                e.preventDefault();
                const row = $(this).closest('tr');

                Swal.fire({
                    title: 'Warning!',
                    text: 'Click Continue to delete this data.',
                    icon: 'warning',
                    confirmButtonText: 'Continue',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-danger",
                    }
                }).then((result) => {
                    if (result.value) {
                        row.fadeOut(300, function() { $(this).remove(); });
                    }
                });
            });
        });
    </script>
@endsection

@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card shadow-sm">

            {{-- HEADER --}}
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h3 style="font-size: 10; font-weight: 600;">User List</h3>
                </div>

                {{-- TOOLBAR --}}
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end">
                        <div class="d-flex align-items-center position-relative me-3">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" data-kt-user-table-filter="search"
                                class="form-control form-control-solid w-200px ps-14"
                                placeholder="Search user" />
                        </div>
                        {{-- FILTER --}}
                        <div class="dropdown">
                            <button type="button" class="btn btn-light-info me-3 dropdown-toggle" data-bs-toggle="dropdown">
                                Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('userlist') }}">All Roles</a></li>

                                @foreach($roles as $role)
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('userlist', ['role' => $role->name]) }}">
                                            {{ $role->display_name ?? $role->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- EXPORT --}}
                        <button type="button" class="btn btn-light-info me-3" id="export-btn">
                            Export
                        </button>

                        {{-- ADD USER --}}
                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="ki-duotone ki-plus-square"></i> Add User
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('admin.stud.create') }}?role=student">Student</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('admin.tech.create') }}?role=technician">Technician</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card-body">

                <style>
                    .page-item.active .page-link {
                        background-color: #7239EA !important;
                        border-color: #7239EA !important;
                        color: #fff !important;
                    }
                    .page-link {
                        color: #7239EA !important;
                    }
                    .page-link:hover {
                        background-color: #ebe0ff !important;
                        color: #7239EA !important;
                    }
                </style>

                <table id="users-table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0">
                            <th>No</th>
                            <th>UserID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="text-black-600 fw-semibold">
                        @foreach($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $user->userid }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>{{ $user->role->name ?? '—' }}</td>

                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-light-success fs-6">Active</span>
                                    @else
                                        <span class="badge badge-light-secondary fs-6">Inactive</span>
                                    @endif
                                </td>

                                <td>{{ $user->created_at?->format('Y-m-d') }}</td>

                                <td>
                                    <a href="{{ route('admin.users.update', $user->id) }}"
                                       class="btn btn-sm btn-info btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="{{ route('admin.users.destroy', $user->id) }}"
                                       class="btn btn-sm btn-danger btn-icon delete-data" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
