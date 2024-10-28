@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">

            <!-- Content -->
            <div class="row my-5">

                <!-- Page Header -->
                <div class="col-md-4 mb-4">
                    <h6 class="card-title fw-semibold fs-22">Asset Delete Log</h6>
                    <p class="card-subtitle mb-3 text-muted fs-12">History</p>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Asset</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('asset-index') }}" >Asset Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Delete Log</li>
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

                <!-- Datatable and Setting -->
                <div class="col-md-8">

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
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page Header -->


            </div>


            <!-- Modal Section -->
            <div class="row">

                <!-- Start Modal Recover Alert -->
                @foreach ($assets as $ass)
                    <div class="modal fade" id="modalRecover-{{ $ass->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body text-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                        fill="currentColor" class="bi bi-arrow-counterclockwise mb-3 mt-3 text-secondary"
                                        viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z" />
                                        <path
                                            d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466" />
                                    </svg>
                                    <h4 class="">Recover back ?</h4>
                                    <p class="text-muted mb-3">This action will recover back your asset details.</p>
                                    <a href="{{ route('asset-recover-process', $ass->id) }}"
                                        class="btn btn-secondary btn-sm">Recover now</a> <button
                                        class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Recover Alert -->


                <!-- Start Modal Delete Alert -->
                @foreach ($assets as $ass)
                    <div class="modal fade" id="modalDelete-{{ $ass->id }}">
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
                                    <p class="text-muted mb-3">This action will permanently delete your asset details. You
                                        cannot revert this anymore !</p>
                                    <a href="{{ route('asset-delete-get-post', $ass->id) }}"
                                        class="btn btn-danger btn-sm">Delete now</a> <button class="btn btn-light btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Delete Alert -->


            </div>
            <!-- End Modal Section -->

        </div>
    </div>
    <!-- End::app-content -->

    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : ASSET
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('asset-delete-log-index') }}",
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]

            });





        });
    </script>
    @include('Asset-Management.layouts.footer')
@endsection
<!-- FULL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 12-07-2024 -->
<!-- ASSET TRANSFER LOG MODULE -->
