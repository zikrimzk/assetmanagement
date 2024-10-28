@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start -->
    <div class="main-content app-content">
        <div class="container">
            <div class="row my-4">
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

                <div class="row my-4">
                    <!-- Page Header -->
                    <div class="col-sm-12 col-md-4 mb-4">
                        <h6 class="card-title fw-semibold fs-22">Asset Transfer</h6>
                        <p class="card-subtitle mb-3 text-muted fs-12">Setting</p>
                        <div class="ms-md-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Asset</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Asset Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Asset Transfer</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="btn-list mt-4">
                            <a href="{{ route('asset-index') }}" class="btn btn-primary-transparent btn-sm">
                                <i class='bx bxs-left-arrow-circle me-2 align-middle d-inline-block'></i>Back
                            </a>
                        </div>
                    </div>
                    <!-- Page Header -->

                    <!-- Transfer Form -->
                    <div class="col-sm-12 col-md-8">
                        <div class="card custom-card shadow-sm">
                            <form action="{{ route('asset-transfer-post') }}" method="POST" id="asset-add-form">
                                @csrf
                                <div class="card-body text-start">
                                    <div class="row">
                                        <input type="hidden" class="form-control" name="trans_1" id="transDescDep">
                                        <input type="hidden" class="form-control" name="trans_2" id="transDescArea">
                                        <input type="hidden" class="form-control" name="asset_id"
                                            value="{{ $ass->id }}">

                                        {{-- Asset Code --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Code</label>
                                            <input type="text" class="form-control" name="asset_code" id="assetcode"
                                                value="{{ $ass->asset_code }}" required readonly>
                                        </div>

                                        {{-- Item --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Asset Item</label>
                                            <select class="form-select" disabled>
                                                @foreach ($items as $item)
                                                    @if ($item->id == $ass->item_id)
                                                        <option value="{{ $item->id }}">
                                                            ({{ $item->item_code }})
                                                            -
                                                            {{ $item->item_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Department --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Department <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" name="dep_id" id="transDep">
                                                @foreach ($deps as $dep)
                                                    @if ($ass->dep_id == $dep->id)
                                                        <option value="{{ $dep->id }}" selected>
                                                            {{ $dep->department_name }} -
                                                            ({{ $dep->department_code }})
                                                        </option>
                                                    @else
                                                        <option value="{{ $dep->id }}">
                                                            {{ $dep->department_name }} -
                                                            ({{ $dep->department_code }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" class="form-control" id="transCurrDep"
                                            value="{{ $ass->dep_id }}">

                                        {{-- Asset Area --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Area <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="area_id" id="transArea">
                                                @foreach ($areas as $area)
                                                    @if ($ass->area_id == $area->id)
                                                        <option value="{{ $area->id }}" selected>
                                                            {{ $area->area_name }} -
                                                            ({{ $area->area_code }})
                                                        </option>
                                                    @else
                                                        <option value="{{ $area->id }}">{{ $area->area_name }}
                                                            -
                                                            ({{ $area->area_code }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" class="form-control" id="transCurrArea"
                                            value="{{ $ass->area_id }}">

                                        {{-- Transfer By --}}
                                        <div class="col-sm-8 mb-2">
                                            <input type="hidden" class="form-control" name="transferby_staffid"
                                                id="input-placeholder" value="{{ Auth::user()->id }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-light">
                                        @if (Auth::user()->staff_role == 1 || Auth::user()->staff_role == 2)
                                            <i class='bx bx-transfer-alt me-2 align-middle fs-18 text-primary'></i>Approve
                                            & Verify Transfer
                                    </button>
                                @elseif(Auth::user()->staff_role == 3)
                                    <i class='bx bx-transfer-alt me-2 align-middle fs-18 text-primary'></i>Request
                                    Transfer</button>
                                @else
                                    <p class="text-muted">You does not have access to make any transfer !</p>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Transfer Form -->
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

    <script type="text/javascript">
        $(document).ready(function() {

            //TRANSFER DESCRIPTION CODE
            $('#transDep').on('change', function() {
                var departmentId = $(this).val();
                var currdep = $('#transCurrDep').val();
                if (departmentId != currdep) {
                    $.ajax({
                        url: '/departments/' + departmentId,
                        method: 'GET',
                        success: function(data) {
                            var desc1 = data.name + ' department';
                            $('#transDescDep').val(desc1);
                        },
                        error: function() {
                            console.error('Failed to fetch department name');
                        }
                    });
                } else {
                    $('#transDescDep').val(''); // Clear the description if no department is selected
                }

            })

            $('#transArea').on('change', function() {
                var AreaId = $(this).val();
                var currArea = $('#transCurrArea').val();
                if (AreaId != currArea) {
                    $.ajax({
                        url: '/areas/' + AreaId,
                        method: 'GET',
                        success: function(data) {
                            var desc1 = data.name + ' area';
                            $('#transDescArea').val(desc1);
                        },
                        error: function() {
                            console.error('Failed to fetch department name');
                        }
                    });
                } else {
                    $('#transDescArea').val(''); // Clear the description if no department is selected
                }

            })





        });
    </script>
    @include('Asset-Management.layouts.footer')
@endsection
<!-- FULL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 12-07-2024 -->
<!-- ASSET TRANSFER MODULE -->
