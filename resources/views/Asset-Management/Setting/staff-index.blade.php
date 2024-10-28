@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-22 mb-0">User / Staff Management</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Staff</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Staff Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header -->


            <!-- Datatable and Setting -->
            <div class="row">
                <div class="mb-5">
                    <!-- Start Alert -->
                    @if (session()->has('success'))
                        <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                            <svg class="flex-shrink-0 me-2 svg-success" xmlns="http://www.w3.org/2000/svg" height="1.5rem"
                                viewBox="0 0 24 24" width="1.5rem" fill="#000000">
                                <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none" />
                                <path
                                    d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
                            </svg>
                            <div>
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                    class="bi bi-x"></i></button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger d-flex align-items-center alert-dismissible" role="alert">
                            <svg class="flex-shrink-0 me-2 svg-danger" xmlns="http://www.w3.org/2000/svg"
                                enable-background="new 0 0 24 24" height="1.5rem" viewBox="0 0 24 24" width="1.5rem"
                                fill="#000000">
                                <g>
                                    <rect fill="none" height="24" width="24" />
                                </g>
                                <g>
                                    <g>
                                        <g>
                                            <path
                                                d="M15.73,3H8.27L3,8.27v7.46L8.27,21h7.46L21,15.73V8.27L15.73,3z M19,14.9L14.9,19H9.1L5,14.9V9.1L9.1,5h5.8L19,9.1V14.9z" />
                                            <rect height="6" width="2" x="11" y="7" />
                                            <rect height="2" width="2" x="11" y="15" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <div>
                                {{ session('error') }}
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                                    class="bi bi-x"></i></button>
                        </div>
                    @endif
                    <!-- End Alert -->

                    <div class="card custom-card shadow-sm">
                        <div class="card-header">
                            <a class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#modalAddStaff">
                                <i class='bx bxs-plus-square me-2 align-middle fs-18'></i>
                                Add Staff</a>

                            <button class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#modalAddStaffExcel">
                                <i class='bx bxs-file-import me-2 align-middle fs-18'></i>
                                Import Excel</button>

                            <div class="btn-group">
                                <button type="button" class="btn btn-light me-2 dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class='bx bxs-file-export me-2 align-middle fs-18'></i>
                                    Export Data
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('staff-export-excel-get') }}">Excel
                                            <span class="fw-bolder">(.xlsx)</span> </a></li>
                                    <li><a class="dropdown-item" href="{{ route('staff-export-pdf-get') }}">Pdf <span
                                                class="fw-bolder">(.pdf)</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                {{-- Company --}}
                                <div class="col-sm-4 mb-2">
                                    <label for="input-placeholder" class="form-label">Filter by Company </label>
                                    <select class="form-select" aria-label="Filter by Company" id="filter-company"
                                        data-column="5">
                                        <option value='' selected>Select</option>
                                        @foreach ($comps as $comp)
                                            <option value="{{ $comp->company_name }}">
                                                {{ $comp->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Button --}}
                                <div class="col-sm-2 mb-2 d-flex  align-items-end ">
                                    <button type="button" class="btn btn-light btn-sm resetBtnsearch"
                                        data-target="#filter-company">Clear</button>
                                </div>

                                {{-- Department --}}
                                <div class="col-sm-4 mb-2">
                                    <label for="input-placeholder" class="form-label">Filter by Department</label>
                                    <select class="form-select" aria-label="Filter by Department" id="filter-department"
                                        data-column="6">
                                        <option value='' selected>Select</option>
                                        @foreach ($deps as $dep)
                                            <option value="{{ $dep->department_name }}">
                                                {{ $dep->department_name }} -
                                                ({{ $dep->department_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Button --}}
                                <div class="col-sm-2 mb-2 d-flex  align-items-end">
                                    <button type="button" class="btn btn-light btn-sm resetBtnsearch"
                                        data-target="#filter-department">Clear</button>
                                </div>



                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap data-table table-hover" id="responsiveDataTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Staff No.</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Phone No.</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Datatable and Setting -->


            <!-- Modal Section -->
            <div class="row">
                <!-- Start Modal Add Staff -->
                <div class="modal fade" id="modalAddStaff">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Staff Details</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('staff-add-post') }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="row">
                                        {{-- Staff Number --}}
                                        <div class="col-sm-5 mb-2">
                                            <label for="input-placeholder" class="form-label">Staff No <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="text" class="form-control" name="staff_no"
                                                id="input-placeholder" required>
                                        </div>
                                        {{-- Name --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Full Name <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="text" class="form-control" name="staff_name"
                                                id="input-placeholder" required>
                                        </div>
                                        {{-- Phone No --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Phone No <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="text" class="form-control" name="staff_phone"
                                                id="input-placeholder" required>
                                        </div>
                                        {{-- Email --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Email <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="email" class="form-control" name="email"
                                                id="input-placeholder" required>
                                        </div>
                                        {{-- Role --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Role <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="staff_role">
                                                <option selected>Select</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Staff</option>
                                                <option value="3">Viewer</option>
                                            </select>
                                            <div class="text-muted">Alert : Different user have different access control.
                                            </div>
                                        </div>
                                        {{-- Status --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Status <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="staff_status">
                                                <option value="0">Not Activated (first-time)</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                            <div class="text-muted">Alert : User will not be activated until they change
                                                their password.</div>
                                        </div>
                                        {{-- Company --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Company <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="comp_id">
                                                <option selected>Select</option>
                                                @foreach ($comps as $comp)
                                                    <option value="{{ $comp->id }}">{{ $comp->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- Department --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Department <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="dep_id">
                                                <option selected>Select</option>
                                                @foreach ($deps as $dep)
                                                    <option value="{{ $dep->id }}">{{ $dep->department_name }} -
                                                        ({{ $dep->department_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Password  --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label ">Password <span
                                                    class="text-muted">(Default : abcd1234)</span> </label>
                                            <input type="password" class="form-control" name="password"
                                                id="input-placeholder" required value="abcd1234">
                                        </div>
                                        {{-- Confirm Password  --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label ">Confirm Password <span
                                                    class="text-muted ">(Default : abcd1234)</span> </label>
                                            <input type="password" class="form-control" name="cpassword"
                                                id="input-placeholder" required value="abcd1234">
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add
                                        Staff</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal Add Department -->

                <!-- Start Modal Import Staff -->
                <div class="modal fade" id="modalAddStaffExcel">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Import Excel</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('staff-import-post') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="row">
                                        {{-- Name --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Choose your file.</label>
                                            <input type="file" class="form-control form-control-file" name="file"
                                                id="file" accept=".csv, .xlsx" required>
                                            <label for="input-placeholder" class=" fs-10 text-muted mt-2">Supported File :
                                                <span class="fw-bolder">(.xlsx) OR (.csv)</span></label>
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <p class="fw-semibold">You can download the
                                                template 
                                            <a href="../TemplateExcel/AssetTrack-Staff-Template.xlsx" class="text-danger text-decoration-underline" 
                                                download>here</a>.
                                            </p>
                                        </div>

                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary-transparent">Import Excel and Save Data</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Modal Import Staff -->

                <!-- Start Modal Edit Staff -->
                @foreach ($staffs as $sta)
                    <div class="modal fade" id="modalUpdateStaff-{{ $sta->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Update Staff Details </h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('staff-edit-post', $sta->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <div class="row">
                                            {{-- Staff Number --}}
                                            <div class="col-sm-5 mb-2">
                                                <label for="input-placeholder" class="form-label">Staff No <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <input type="text" class="form-control" name="staff_no"
                                                    id="input-placeholder" required value="{{ $sta->staff_no }}">
                                            </div>
                                            {{-- Name --}}
                                            <div class="col-sm-12 mb-2">
                                                <label for="input-placeholder" class="form-label">Full Name <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <input type="text" class="form-control" name="staff_name"
                                                    id="input-placeholder" required value="{{ $sta->staff_name }}">
                                            </div>
                                            {{-- Phone No --}}
                                            <div class="col-sm-6 mb-2">
                                                <label for="input-placeholder" class="form-label">Phone No <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <input type="text" class="form-control" name="staff_phone"
                                                    id="input-placeholder" required value="{{ $sta->staff_phone }}">
                                            </div>
                                            {{-- Email --}}
                                            <div class="col-sm-6 mb-2">
                                                <label for="input-placeholder" class="form-label">Email <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <input type="email" class="form-control" name="email"
                                                    id="input-placeholder" required value="{{ $sta->email }}">
                                            </div>
                                            {{-- Role --}}
                                            <div class="col-sm-6 mb-2">
                                                <label for="input-placeholder" class="form-label">Role <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="staff_role">
                                                    @if ($sta->staff_role == '1')
                                                        <option value="1" selected>Admin</option>
                                                        <option value="2">Staff</option>
                                                        <option value="3">Viewer</option>
                                                    @elseif($sta->staff_role == '2')
                                                        <option value="1">Admin</option>
                                                        <option value="2" selected>Staff</option>
                                                        <option value="3">Viewer</option>
                                                    @elseif($sta->staff_role == '3')
                                                        <option value="1">Admin</option>
                                                        <option value="2">Staff</option>
                                                        <option value="3" selected>Viewer</option>
                                                    @endif
                                                </select>
                                            </div>
                                            {{-- Status --}}
                                            <div class="col-sm-6 mb-2">
                                                <label for="input-placeholder" class="form-label">Status <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="staff_status">
                                                    @if ($sta->staff_status == '1')
                                                        <option value="1">Active</option>
                                                        <option value="2">Inactive</option>
                                                    @elseif($sta->staff_status == '2')
                                                        <option value="2">Inactive</option>
                                                        <option value="1">Active</option>
                                                    @elseif($sta->staff_status == '0')
                                                        <option value="0">Not Activated (first-time)</option>
                                                    @endif
                                                </select>
                                            </div>
                                            {{-- Company --}}
                                            <div class="col-sm-6 mb-2">
                                                <label for="input-placeholder" class="form-label">Company <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="comp_id">
                                                    @foreach ($comps as $comp)
                                                        @if ($sta->comp_id == $comp->id)
                                                            <option value="{{ $comp->id }}" selected>
                                                                {{ $comp->company_name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $comp->id }}">{{ $comp->company_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- Department --}}
                                            <div class="col-sm-6 mb-2">
                                                <label for="input-placeholder" class="form-label">Department <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <select class="form-select" aria-label="Default select example"
                                                    name="dep_id">

                                                    @foreach ($deps as $dep)
                                                        @if ($sta->dep_id == $dep->id)
                                                            <option value="{{ $dep->id }}" selected>
                                                                {{ $dep->department_name }}
                                                            </option>
                                                        @elseif($sta->dep_id != $dep->id)
                                                            <option value="{{ $dep->id }}">
                                                                {{ $dep->department_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($sta->staff_status != '0')
                                                {{-- AFRP --}}
                                                <div class="col-sm-12 mb-2 mt-3">
                                                    <label for="input-placeholder" class="form-label">Admin Force Reset
                                                        Password (AFRP)</label>
                                                    <label for="input-placeholder" class="form-label"><span
                                                            class="text-danger fw-semibold">(Alert: Click only when the
                                                            user
                                                            forget
                                                            the password !)</span> </label>
                                                    <a href="{{ route('staff-reset-password', $sta->id) }}"
                                                        class="btn btn-danger btn-sm"><i class="bx bxs-key me-2"></i>
                                                        Force
                                                        Reset Password</a>

                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes
                                        </button>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Edit Staff -->


                <!-- Start Modal Delete Alert -->
                @foreach ($staffs as $sta)
                    <div class="modal fade" id="modalDelete-{{ $sta->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body text-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                        fill="currentColor" class="bi bi-exclamation-triangle-fill text-danger mb-3 mt-3"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                    </svg>
                                    <h4 class="">Are you sure ?</h4>
                                    <p class="text-muted mb-3">This action will the terminated the staff and cannot be
                                        recover back !</p>
                                    <a href="{{ route('staff-delete-get-post', $sta->id) }}"
                                        class="btn btn-danger btn-sm">Delete now</a> <button class="btn btn-light btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Delete Alert -->

            </div>
            <!-- Modal Section -->

        </div>
    </div>
    <!-- End -->

    <script type="text/javascript">
        $(document).ready(function() {

            //AJAX: DATATABLE STAFF
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('staff-index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'staff_no',
                        name: 'staff_no'
                    },
                    {
                        data: 'staff_name',
                        name: 'staff_name'
                    },
                    {
                        data: 'staff_phone',
                        name: 'staff_phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'staff_role',
                        name: 'staff_role'
                    },
                    {
                        data: 'staff_status',
                        name: 'staff_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }


                ]

            });

            //AJAX: Filters Code
            function applyFilters() {
                $('#filter-company, #filter-department').each(function() {
                    var columnIdx = $(this).data('column');
                    var filterValue = $(this).val();
                    table.column(columnIdx).search(filterValue);
                });
                table.draw();
            }

            $('#filter-company, #filter-department').on('change', function() {
                applyFilters();
            });

            $('.resetBtnsearch').on('click', function() {
                var target = $(this).data('target');
                $(target).val('');
                applyFilters();
            })



        });
    </script>
    @include('Asset-Management.layouts.footer')
@endsection

<!-- FINAL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 04-07-2024 -->
<!-- STAFF MANAGEMENT MODULE -->
<!--
    UPDATE LOG

    ID   : UP001
    NAME : ASRP ( ADMIN-FORCE-RESET-PASSWORD)
    DATE : 10-07-2024

    ID   : UP002
    NAME : EXCEL TEMPLATE EMBEDDED LINK + TEMPLATE CHECKING
    DATE : 14-07-2024
-->
