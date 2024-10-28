<?php
use Illuminate\Support\Str;
use App\Models\Department;
?>
@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start -->
    <div class="main-content app-content">
        <div class="container">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-22 mb-0">Asset Management</h1>

                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Asset</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Asset Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header -->


            <!-- Administrator Setting -->
            @if (Auth::user()->staff_role == 1 || Auth::user()->staff_role == 2)
                <div class="card custom-card shadow-sm">
                    <div class="card-header">

                        <a class="btn me-2 btn-primary" href="{{ route('asset-type-index') }}">
                            <i class='bx bxs-collection me-2 align-middle fs-18'></i>
                            Asset Type</a>

                        <a class="btn  me-2 btn-primary" href="{{ route('asset-item-index') }}">
                            <i class='bx bxs-book-content me-2 align-middle fs-18'></i>
                            Asset Item</a>
                        <a class="btn me-2 btn-primary position-relative"
                            href="{{ route('asset-transfer-approval-index') }}">
                            <i class='bx bx-list-check me-2 align-middle fs-18'></i>
                            Transfer Approval
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info-gradient count">
                                <span class="visually-hidden">unread messages</span>
                            </span></a>
                        @if (Auth::user()->staff_role == 1)
                            <a class="btn  me-2 btn-primary" href="{{ route('asset-delete-log-index') }}">
                                <i class='bx bx-history me-2 align-middle fs-18'></i>
                                Delete Log</a>
                        @endif
                    </div>
                </div>
            @endif
            <!-- Administrator Setting -->


            <!-- Datatable and Setting -->
            <div class="row">
                <div class="mb-5">
                    <!-- Start Alert -->
                    @if (session()->has('success'))
                        {{-- @dd(session()->all()); --}}
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
                    {{-- @dd(session()->all()); --}}
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
                            @if (Auth::user()->staff_role == 1 || Auth::user()->staff_role == 2)
                                <a class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#modalAddAsset">
                                    <i class='bx bxs-plus-square me-2 align-middle fs-18 text-primary'></i>
                                    Declare Asset</a>

                                <button class="btn btn-light me-2" data-bs-toggle="modal"
                                    data-bs-target="#modalAddAssetExcel">
                                    <i class='bx bxs-file-import me-2 align-middle fs-18 text-primary'></i>
                                    Import Excel</button>
                            @endif

                            <div class="btn-group">
                                <button type="button" class="btn btn-light me-2 dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class='bx bxs-file-export me-2 align-middle fs-18 text-primary'></i>
                                    Export Data
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('asset-export-excel-get') }}">Excel
                                            <span class="fw-bolder">(.xlsx)</span> </a></li>
                                    <li><a class="dropdown-item" href="{{ route('asset-export-pdf-get') }}">Pdf <span
                                                class="fw-bolder">(.pdf)</span></a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#modalExCustom">Custom
                                            </span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                {{-- Company --}}
                                <div class="col-sm-3 mb-2">
                                    <label for="input-placeholder" class="form-label">Filter by Company </label>
                                    <select class="form-select" aria-label="Filter by Company" id="filter-company"
                                        data-column="9">
                                        <option value='' selected>Select</option>
                                        @foreach ($comps as $comp)
                                            <option value="{{ $comp->id }}">
                                                {{ $comp->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Button --}}
                                <div class="col-sm-1 mb-2 d-flex  align-items-end">
                                    <button type="button" class="btn btn-light resetBtnsearch"
                                        data-target="#filter-company">Clear</button>
                                </div>
                                {{-- Department --}}
                                <div class="col-sm-3 mb-2">
                                    <label for="input-placeholder" class="form-label">Filter by Department</label>
                                    <select class="form-select" aria-label="Filter by Department" id="filter-department"
                                        data-column="10">
                                        <option value='' selected>Select</option>
                                        @foreach ($deps as $dep)
                                            <option value="{{ $dep->id }}">
                                                {{ $dep->department_name }} -
                                                ({{ $dep->department_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Button --}}
                                <div class="col-sm-1 mb-2 d-flex  align-items-end">
                                    <button type="button" class="btn btn-light resetBtnsearch"
                                        data-target="#filter-department">Clear</button>
                                </div>
                                {{-- Asset Area --}}
                                <div class="col-sm-3 mb-2">
                                    <label for="input-placeholder" class="form-label">Filter by Area</label>
                                    <select class="form-select" aria-label="Filter by Area" id="filter-area"
                                        data-column="11">
                                        <option value='' selected>Select</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->company_code }}|
                                                {{ $area->area_name }} -
                                                ({{ $area->area_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Button --}}
                                <div class="col-sm-1 mb-2 d-flex  align-items-end">
                                    <button type="button" class="btn btn-light resetBtnsearch"
                                        data-target="#filter-area">Clear</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap data-table table-hover" id="responsiveDataTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Coding</th>
                                            <th scope="col">Serial No.</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Cost (RM)</th>
                                            <th scope="col">Market Value (RM)</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Remarks</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
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
                <!-- Start Modal Add Asset -->
                <div class="modal fade" id="modalAddAsset">
                    <div class="modal-dialog modal-dialog-centered text-center modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Asset Declaration</h6><button aria-label="Close"
                                    class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('asset-add-post') }}" method="POST" id="asset-add-form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="row">
                                        <div class="fw-semibold fs-14 mb-3 text-primary">Coding & Asset Location</div>
                                        {{-- Asset Code --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Code <span
                                                    class="text-muted">(auto-generated)</span> </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="asset_code"
                                                    id="assetcode" required readonly>
                                                <div class="input-group-text " id="btn-ref" style="cursor: pointer;"><i
                                                        class='bx bx-refresh fs-18'></i></div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        {{-- Company --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Company <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="comp_id" id="compcode">
                                                <option value="XXXX" selected>Select</option>
                                                @foreach ($comps as $comp)
                                                    <option value="{{ $comp->company_code }}">
                                                        {{ $comp->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Item --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Asset Item <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="item_id" required id="itemcode">
                                                <option value="XXXX" selected>Select</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->item_code }}">({{ $item->item_code }}) -
                                                        {{ $item->item_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Department --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Department <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="dep_id" id="depcode" required>
                                                <option value="XX" selected>Select</option>
                                                @foreach ($deps as $dep)
                                                    <option value="{{ $dep->department_code }}">
                                                        {{ $dep->department_name }} -
                                                        ({{ $dep->department_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Area --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Area <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="area_id" id="areacode" required>
                                                <option value="XX" selected>Select</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->area_code }}">({{ $area->company_code }}) -
                                                        {{ $area->area_name }} ({{ $area->area_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Date --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Date of purchase <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <div class="input-group">
                                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                                </div>
                                                <input type="text" class="form-control" id="date"
                                                    placeholder="Choose date" required name="asset_date"
                                                    value="01-01-2024">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="fw-semibold fs-14 mb-3 text-primary">Asset Details</div>
                                        {{-- Asset Serial No --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Serial No </label>
                                            <input type="text" class="form-control" name="asset_serialno"
                                                id="serialno">
                                            <span class="text-muted">Leave (-) if empty</span>
                                        </div>

                                        {{-- Asset Brand --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Brand</label>
                                            <input type="text" class="form-control" name="asset_brand"
                                                id="brand">
                                            <span class="text-muted">Leave (-) if empty</span>

                                        </div>

                                        {{-- Asset Cost  --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label ">Cost (RM) </label>
                                            <input type="text" class="form-control c-input" name="asset_cost"
                                                id="cost" value="0">
                                            <span class="text-muted">Enter 0 if does not have value</span>

                                        </div>

                                        {{-- Asset Market Value  --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label ">Market Value (RM) </label>
                                            <input type="text" class="form-control c-input" name="asset_marketval"
                                                id="marketvalue" value="0">
                                            <span class="text-muted">Enter 0 if does not have value</span>

                                        </div>

                                        {{-- Asset Status --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Status <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="asset_status" id="status">
                                                <option value="" selected>Select</option>
                                                <option value="1">Active</option>
                                                <option value="2">Under Maintenance</option>
                                                <option value="3">Broken</option>
                                                <option value="4">Disposed</option>
                                            </select>
                                        </div>

                                        {{-- Asset Remarks --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Remarks </label>
                                            <input type="text" class="form-control" name="asset_remarks"
                                                id="remarks">
                                            <span class="text-muted">Leave (-) if empty</span>

                                        </div>

                                        {{-- Asset Image --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Image </label>
                                            <input type="file" class="form-control" name="asset_image"
                                                id="images">
                                            <img class='img-thumbnail ' id="image-preview" src="#"
                                                style="display: none;">
                                        </div>

                                        {{-- Added By --}}
                                        <div class="col-sm-6 mb-2">
                                            <input type="hidden" class="form-control" name="staff_id"
                                                id="input-placeholder" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" id="resetBtn">Clear</button>
                                    <button type="submit" class="btn btn-primary">Add
                                        Asset</button>
                                </div>

                            </form>

                            <form action="{{ route('asset-update-seq') }}" method="POST" id="formseqno">
                                @csrf
                                <input type="hidden" name="item_code" id="itemcode_update">
                                <input type="hidden" id="seqno">
                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Modal Add Asset -->

                <!-- Start Modal Delete Alert -->
                @foreach ($assets as $ass)
                    <div class="modal fade" id="modalDelete-{{ $ass->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body text-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                        fill="currentColor" class="bi bi-exclamation-triangle-fill text-warning mb-3 mt-3"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                    </svg>
                                    <h4 class="">Are you sure ?</h4>
                                    <p class="text-muted mb-3">All the deleted asset will be saved in asset delete log</p>
                                    <a href="{{ route('asset-temp-delete-get-post', $ass->id) }}"
                                        class="btn btn-warning btn-sm">Delete now</a> <button class="btn btn-light btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Delete Alert -->


                <!-- Start Modal Import Asset -->
                <div class="modal fade" id="modalAddAssetExcel">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Import Excel</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <form action="{{ route('asset-import-post') }}" method="POST"
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
                                                <a href="../TemplateExcel/AssetTrack-Asset-Template.xlsx"
                                                    class="text-danger text-decoration-underline" download>here</a>.
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary-transparent">Import Excel and Save
                                        Data</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Modal Import Asset -->

                <!-- Start Modal Custom Export -->
                <div class="modal fade" id="modalExCustom">
                    <div class="modal-dialog modal-dialog-centered text-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Custom Export</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('asset-export-custom-excel') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-start">
                                    <div class="row">
                                        {{-- Company --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Filter by Company </label>
                                            <select class="form-select" aria-label="Filter by Company" id="ex-company"
                                                name="comp_id">
                                                <option value='' selected>Select</option>
                                                @foreach ($comps as $comp)
                                                    <option value="{{ $comp->id }}">
                                                        {{ $comp->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Department --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Filter by Department</label>
                                            <select class="form-select" aria-label="Filter by Department"
                                                id="ex-department" name="dep_id">
                                                <option value='' selected>Select</option>
                                                @foreach ($deps as $dep)
                                                    <option value="{{ $dep->id }}">
                                                        {{ $dep->department_name }} -
                                                        ({{ $dep->department_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Area --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Filter by Area</label>
                                            <select class="form-select" aria-label="Filter by Area" id="ex-area"
                                                name="area_id">
                                                <option value='' selected>Select</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->area_name }} -
                                                        ({{ $area->area_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Export Excel</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- End Modal Custom Export -->
            </div>
            <!-- Modal Section -->



        </div>
    </div>
    <!-- End -->

    <script type="text/javascript">
        $(document).ready(function() {

            // RESET FIELD CODE
            function clearAll() {
                $('#compcode').val('XXXX').change();
                $('#depcode').val('XX').change();
                $('#areacode').val('XX').change();
                $('#itemcode').val('XXXX').change();
                $('#date').val('2024-01-01');
                $('#seqno').val('');
                $('#assetcode').val('');
                $('#serialno').val('');
                $('#brand').val('');
                $('#cost').val(0);
                $('#marketvalue').val(0);
                $('#status').val('').change();
                $('#remarks').val('');
                $('#images').val('');
            }
            $('#resetBtn').on('click', clearAll);


            // AUTO-GENERATED CODE CODING
            function updateAssetCode() {
                var comps = $('#compcode').val();
                var deps = $('#depcode').val();
                var areas = $('#areacode').val();
                var items = $('#itemcode').val();
                var date = $('#date').val();
                var d = new Date(date);
                //convert day to string
                var day = ("0" + (d.getMonth() + 1)).slice(-2);
                //get the year
                var year = d.getFullYear();
                //pull the last two digits of the year
                year = year.toString().substr(-2);

                var seqnos = $('#seqno').val();

                var code = comps + '/' + deps + areas + '/' + items + '/' + day + year + '/' + seqnos;
                $('#assetcode').val(code);
            }

            $('#compcode, #itemcode , #depcode, #areacode, #date').on('change', function() {
                updateAssetCode();
                setInterval(updateAssetCode, 1000);
            });

            $('#itemcode').on('change', updateAssetCode);

            $('#btn-ref').on('click', updateAssetCode);

            $('#itemcode').on('change', function() {
                $('#itemcode_update').val($(this).val());
                $('#formseqno').submit();
                updateAssetCode();

            });


            // AJAX : UPDATE SEQUENCE NUMBER
            $('#formseqno').on('submit', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('asset-update-seq') }}",
                    data: jQuery('#formseqno').serialize(),
                    type: "POST",
                    success: function(result) {
                        var data = result.data;
                        $('#seqno').val(data);

                    }

                })
            });

            // AJAX : ADD ASSET
            $('#asset-add-form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                jQuery.ajax({
                    url: "{{ route('asset-add-post') }}",
                    data: formData,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    success: function(result) {
                        var success = result.success;
                        if (success != undefined) {
                            alert(success);
                            $("#modalAddAsset").modal("hide");
                            $('.data-table').DataTable().ajax.reload();
                            clearAll();

                        }
                        var error = result.error;
                        if (error != undefined) {
                            alert(error);
                        }


                    }

                })
            });

            // DATATABLE : ASSET
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('asset-index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'asset_code',
                        name: 'asset_code'
                    },
                    {
                        data: 'asset_serialno',
                        name: 'asset_serialno',
                        visible: false

                    },
                    {
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'asset_cost',
                        name: 'asset_cost',
                        visible: false

                    },
                    {
                        data: 'asset_marketval',
                        name: 'asset_marketval',
                        visible: false

                    },
                    {
                        data: 'asset_brand',
                        name: 'asset_brand'
                    },
                    {
                        data: 'asset_remarks',
                        name: 'asset_remarks',
                        visible: false

                    },
                    {
                        data: 'asset_status',
                        name: 'asset_status'
                    },
                    {
                        data: 'comp_id',
                        name: 'comp_id',
                        searchable: true,
                        visible: false

                    },
                    {
                        data: 'dep_id',
                        name: 'dep_id',
                        searchable: true,
                        visible: false

                    },
                    {
                        data: 'area_id',
                        name: 'area_id',
                        searchable: true,
                        visible: false

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });

            //Filters Code
            function applyFilters() {
                $('#filter-company, #filter-department, #filter-area').each(function() {
                    var columnIdx = $(this).data('column');
                    var filterValue = $(this).val();
                    table.column(columnIdx).search(filterValue);
                });
                table.draw();
            }

            $('#filter-company, #filter-department, #filter-area').on('change', function() {
                applyFilters();
            });

            $('.resetBtnsearch').on('click', function() {
                var target = $(this).data('target');
                $(target).val('');
                applyFilters();
            })

            //Approval Count Code
            function countNumberApproval() {
                $.ajax({
                    url: '/approvalcount',
                    method: 'GET',
                    success: function(data) {
                        var num = data.count;
                        $('.count').text(num);
                    },
                    error: function() {
                        console.error('Failed to fetch count');
                    }
                });

            }
            countNumberApproval();
            setInterval(countNumberApproval, 1000);


            // Currentcy Input Format
            $('.c-input').on('input', function(event) {
                let value = event.target.value.replace(/\D/g, ''); // Remove all non-digit characters
                if (value.length === 0) {
                    event.target.value = '';
                    return;
                }

                // Format the value to have two decimal places
                if (value.length <= 2) {
                    // event.target.value = '0.' + value.padStart(2, '0');
                } else {
                    let mainPart = value.slice(0, -2);
                    let decimalPart = value.slice(-2);
                    event.target.value = mainPart + '.' + decimalPart;
                }

            });
        });
    </script>

    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.getElementById('image-preview');
                img.src = e.target.result;
                img.style.display = 'block';
            }

            reader.readAsDataURL(file);
        });
    </script>
    @include('Asset-Management.layouts.footer')
@endsection
<!-- PARTIALLY CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 10-07-2024 -->
<!-- ASSET MANAGAMENT MAIN MODULE -->
<!--
    UPDATE LOG

    ID   : UP001
    NAME : EXCEL TEMPLATE EMBEDDED LINK + TEMPLATE CHECKING
    DATE : 14-07-2024

    ID   : UP002
    NAME : FIXES AREA FILTER BUGS + ADD AREA CODE IN THE SELECT PART
    DATE : 24-07-2024


-->
