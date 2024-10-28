@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start-->
    <div class="main-content app-content">
        <div class="container">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-22 mb-0">Department Management</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Staff</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Department Management</li>
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
                            <a class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#modalAddDepartment">
                                <i class='bx bxs-plus-square me-2 align-middle fs-18'></i>
                                Add Department</a>

                            <button class="btn btn-light me-2" data-bs-toggle="modal"
                                data-bs-target="#modalAddDepartmentExcel">
                                <i class='bx bxs-file-import me-2 align-middle fs-18'></i>
                                Import Excel</button>

                            <div class="btn-group">
                                <button type="button" class="btn btn-light me-2 dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class='bx bxs-file-export me-2 align-middle fs-18'></i>
                                    Export Data
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('department-export-excel-get') }}">Excel
                                            <span class="fw-bolder">(.xlsx)</span> </a></li>
                                    <li><a class="dropdown-item" href="{{ route('department-export-pdf-get') }}">Pdf <span
                                                class="fw-bolder">(.pdf)</span></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap data-table table-hover" id="responsiveDataTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Department Name</th>
                                            <th scope="col">Code</th>
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
                <!-- Start Modal Add Department -->
                <div class="modal fade" id="modalAddDepartment">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Department Details</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('department-add-post') }}" method="POST">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="row">
                                        {{-- Name --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Department Name <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="text" class="form-control" name="department_name"
                                                id="input-placeholder" required>
                                        </div>
                                        {{-- Code  --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label ">Department Code <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="text" class="form-control" name="department_code"
                                                id="input-placeholder" required>
                                        </div>


                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add
                                        Department</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Modal Add Department -->

                <!-- Start Modal Import Department -->
                <div class="modal fade" id="modalAddDepartmentExcel">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Import Excel</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('department-import-post') }}" method="POST"
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
                                            <a href="../TemplateExcel/AssetTrack-Department-Template.xlsx" class="text-danger text-decoration-underline" 
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
                <!-- End Modal Import Department -->


                <!-- Start Modal Edit Department -->
                @foreach ($deps as $dep)
                    <div class="modal fade" id="modalUpdateDepartment-{{ $dep->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">Update Department </h6><button aria-label="Close"
                                        class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('department-edit-post', $dep->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-start">
                                        <div class="row">
                                            {{-- Name --}}
                                            <div class="col-sm-12 mb-2">
                                                <label for="input-placeholder" class="form-label">Department Name <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <input type="text" class="form-control" name="department_name"
                                                    id="input-placeholder" required value="{{ $dep->department_name }}">
                                            </div>
                                            {{-- Code  --}}
                                            <div class="col-sm-12 mb-2">
                                                <label for="input-placeholder" class="form-label ">Department Code <span
                                                        class="text-danger fw-bold">*</span> </label>
                                                <input type="text" class="form-control" name="department_code"
                                                    id="input-placeholder" required value="{{ $dep->department_code }}">
                                            </div>


                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Edit Department -->


                <!-- Start Modal Delete Alert -->
                @foreach ($deps as $dep)
                    <div class="modal fade" id="modalDelete-{{ $dep->id }}">
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
                                    <p class="text-muted mb-3">You cannot revert this anymore !</p>
                                    <a href="{{ route('department-delete-get-post', $dep->id) }}"
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
    <!-- End-->

    <script type="text/javascript">
        $(document).ready(function() {

            // AJAX: DATATABLE DEPARTMENT
            $(function() {

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    pageLength: 50,
                    ajax: "{{ route('department-index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'department_name',
                            name: 'department_name'
                        },
                        {
                            data: 'department_code',
                            name: 'department_code'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }


                    ]

                });

            });


        });
    </script>
    @include('Asset-Management.layouts.footer')
@endsection
<!-- FINAL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 04-07-2024 -->
<!-- DEPARTMENT MANAGEMENT MODULE -->
<!--
    UPDATE LOG

    ID   : UP001
    NAME : EXCEL TEMPLATE EMBEDDED LINK + TEMPLATE CHECKING
    DATE : 14-07-2024
-->
