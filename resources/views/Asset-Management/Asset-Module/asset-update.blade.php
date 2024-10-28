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
                        <h6 class="card-title fw-semibold fs-22">Asset Details</h6>
                        <p class="card-subtitle mb-3 text-muted fs-12">Update</p>
                        <div class="ms-md-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Asset</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Asset Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Asset Update</li>
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

                    <!-- Update Form -->
                    <div class="col-sm-12 col-md-8">
                        <div class="card custom-card shadow-sm">

                            <form action="{{ route('asset-edit-post', $ass->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="fw-semibold fs-14 mb-3 text-primary">Coding & Asset Location</div>
                                        {{-- Asset Code --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Code <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="asset_code" id="assetcodeu"
                                                    required value="{{ $ass->asset_code }}" readonly>
                                                <div class="input-group-text " id="btn-refu" style="cursor: pointer;"><i
                                                        class='bx bx-refresh fs-18'></i></div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        {{-- Company --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Company <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example" name="comp_id"
                                                id="compcodeu">
                                                @foreach ($comps as $comp)
                                                    @if ($ass->comp_id == $comp->id)
                                                        <option value="{{ $comp->company_code }}" selected>
                                                            {{ $comp->company_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $comp->company_code }}">
                                                            {{ $comp->company_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Item --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Asset Item <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <input type="hidden" name="item_id" value="{{ $ass->item_id }}">
                                            <select class="form-select disabled" aria-label="Default select example"
                                                id="itemcodeu" disabled>
                                                @foreach ($items as $item)
                                                    @if ($ass->item_id == $item->id)
                                                        <option value="{{ $item->item_code }}" selected>
                                                            ({{ $item->item_code }})
                                                            -
                                                            {{ $item->item_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Department --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Department <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="dep_id" id="depcodeu" required>

                                                @foreach ($deps as $dep)
                                                    @if ($ass->dep_id == $dep->id)
                                                        <option value="{{ $dep->department_code }}" selected>
                                                            {{ $dep->department_name }} -
                                                            ({{ $dep->department_code }})
                                                        </option>
                                                    @else
                                                        <option value="{{ $dep->department_code }}">
                                                            {{ $dep->department_name }} -
                                                            ({{ $dep->department_code }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Asset Area --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Area <span
                                                    class="text-danger fw-bold">*</span> </label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="area_id" id="areacodeu" required>

                                                @foreach ($areas as $area)
                                                    @if ($ass->area_id == $area->id)
                                                        <option value="{{ $area->area_code }}" selected>
                                                            ({{ $area->company_code }})
                                                            - {{ $area->area_name }} ({{ $area->area_code }})
                                                        </option>
                                                    @else
                                                        <option value="{{ $area->area_code }}">
                                                            ({{ $area->company_code }}) - {{ $area->area_name }} ({{ $area->area_code }})
                                                        </option>
                                                    @endif
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
                                                <input type="text" class="form-control date" id="date"
                                                    placeholder="Choose date" required name="asset_date"
                                                    value="{{ $ass->asset_date }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="fw-semibold fs-14 mb-3 text-primary">Asset Details</div>
                                        {{-- Asset Serial No --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Serial No </label>
                                            <input type="text" class="form-control" name="asset_serialno"
                                                id="input-placeholder" value="{{ $ass->asset_serialno }}">
                                        </div>

                                        {{-- Asset Brand --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Brand</label>
                                            <input type="text" class="form-control" name="asset_brand"
                                                id="input-placeholder" value="{{ $ass->asset_brand }}">
                                        </div>

                                        {{-- Asset Cost  --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label ">Cost (RM) </label>
                                            <input type="text" class="form-control c-input" name="asset_cost"
                                                id="input-placeholder" value="{{ $ass->asset_cost }}">
                                        </div>

                                        {{-- Asset Market Value  --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label ">Market Value (RM)
                                            </label>
                                            <input type="text" class="form-control c-input" name="asset_marketval"
                                                id="input-placeholder" value="{{ $ass->asset_marketval }}">
                                        </div>

                                        {{-- Asset Status --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Status <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <select class="form-select" aria-label="Default select example"
                                                name="asset_status" required>

                                                @if ($ass->asset_status == 1)
                                                    <option value="1" selected>Active</option>
                                                    <option value="2">Under Maintenance</option>
                                                    <option value="3">Broken</option>
                                                    <option value="4">Disposed</option>
                                                @elseif($ass->asset_status == 2)
                                                    <option value="1">Active</option>
                                                    <option value="2" selected>Under Maintenance</option>
                                                    <option value="3">Broken</option>
                                                    <option value="4">Disposed</option>
                                                @elseif($ass->asset_status == 3)
                                                    <option value="1">Active</option>
                                                    <option value="2">Under Maintenance</option>
                                                    <option value="3" selected>Broken</option>
                                                    <option value="4">Disposed</option>
                                                @elseif($ass->asset_status == 4)
                                                    <option value="1">Active</option>
                                                    <option value="2">Under Maintenance</option>
                                                    <option value="3">Broken</option>
                                                    <option value="4" selected>Disposed</option>
                                                @endif

                                            </select>
                                        </div>

                                        {{-- Asset Remarks --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Remarks </label>
                                            <input type="text" class="form-control" name="asset_remarks"
                                                id="input-placeholder" value="{{ $ass->asset_remarks }}">
                                        </div>

                                        {{-- Asset Image --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Image </label>
                                            <input type="file" class="form-control" id="images"
                                                name="asset_image">
                                            <img class='img-thumbnail' id="image-preview"
                                                src="../storage/{{ $ass->asset_image }}" alt="No image to preview...">
                                            <input type="hidden" name="image_isHaveChange" value="F"
                                                id="image_isHave">
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-light">
                                        <i class='bx bxs-check-circle me-2 align-middle fs-18 text-primary'></i>Save
                                        Changes</button>
                                </div>
                            </form>

                            <form action="{{ route('asset-update-seq') }}" method="POST" id="formseqnou">
                                @csrf
                                <input type="hidden" name="item_code" id="itemcode_updateu">
                                <input type="hidden" id="seqnou" value="{{ Str::substr($ass->asset_code, 20) }}">
                            </form>


                        </div>


                    </div>
                    <!-- Update Form -->
                </div>
            </div>

        </div>
    </div>
    <!-- End -->

    <script type="text/javascript">
        $(document).ready(function() {

            // UPDATE CODE 
            function updateAssetCodeU() {
                var comps = $('#compcodeu').val();
                var deps = $('#depcodeu').val();
                var areas = $('#areacodeu').val();
                var items = $('#itemcodeu').val();
                var date = $('.date').val();
                var d = new Date(date);
                //convert day to string
                var day = ("0" + (d.getMonth() + 1)).slice(-2);
                //get the year
                var year = d.getFullYear();
                //pull the last two digits of the year
                year = year.toString().substr(-2);

                var seqnos = $('#seqnou').val();

                var code = comps + '/' + deps + areas + '/' + items + '/' + day + year + '/' + seqnos;
                $('#assetcodeu').val(code);
            }

            $('#compcodeu, #itemcodeu , #depcodeu, #areacodeu, .date').on('change', function() {
                updateAssetCodeU();
                setInterval(updateAssetCodeU, 1000);
            });

            $('#btn-refu').on('click', updateAssetCodeU);


            $('#itemcodeu').on('change', function() {
                $('#itemcode_updateu').val($(this).val());
                $('#formseqnou').submit();
                updateAssetCodeU();
            });

            $('#formseqnou').on('submit', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('asset-update-seq') }}",
                    data: jQuery('#formseqnou').serialize(),
                    type: "POST",
                    success: function(result) {
                        var data = result.data;
                        $('#seqnou').val(data);

                    }

                })
            });

            // CURRENTCY FORMAT CODE
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

            //IMAGE UPDATE DECISION CODE
            $('#images').on('change', function() {
                $('#image_isHave').val('T');
            })


        });
    </script>

    <script>
        //IMAGE PREVIEW CODE
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
<!-- FULL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 13-07-2024 -->
<!-- ASSET UPDATE MODULE -->
<!--
    UPDATE LOG

    ID   : UP001
    NAME : FIXES AREA FILTER BUGS + ADD AREA CODE IN THE SELECT PART
    DATE : 24-07-2024


-->
