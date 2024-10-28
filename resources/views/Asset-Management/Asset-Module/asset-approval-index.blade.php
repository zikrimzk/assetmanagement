@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start -->
    <div class="main-content app-content">
        <div class="container">
            <div class="row my-5">
                <!-- Page Header -->
                <div class="col-md-4 mb-4">

                    <h6 class="card-title fw-semibold fs-22">Asset Transfer</h6>
                    <p class="card-subtitle mb-3 text-muted fs-12">Approval</p>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Asset</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('asset-index') }}">Asset Management</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Transfer Approval</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="btn-list mt-4">
                        <a href="{{ route('asset-index') }}" class="btn btn-primary-transparent btn-sm">
                            <i class='bx bxs-left-arrow-circle me-2 align-middle d-inline-block'></i>Back
                        </a>
                        <a href="{{ route('asset-transfer-log-index') }}" class="btn btn-primary btn-sm"> <i
                                class='bx bx-history me-1 align-middle fs-12'></i>Transfer Log
                        </a>
                    </div>
                </div>
                <!-- Page Header -->

                <!-- Datatable & Setting -->
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
                                            <th scope="col">Item</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Transfer Status</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Transfer by</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Datatable & Setting -->
            </div>

            <!-- Modal Section -->
            <div class="row">

                <!-- Start Modal Approve Transfer -->
                @foreach ($assets as $ass)
                    <div class="modal fade" id="modalApprove-{{ $ass->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body text-center mb-3">
                                    <svg class="custom-alert-icon svg-success mb-3 mt-3" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" width="50" height="50" fill="#000000">
                                        <path d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                    </svg>
                                    <h4 class="">Approve transfer request ?</h4>
                                    <p class="text-muted mb-3">This action will update the new location of the asset.</p>
                                    <a href="{{ route('asset-approval-process', $ass->id) }}"
                                        class="btn btn-success btn-sm">Yes, approve</a> <button class="btn btn-light btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Approve Transfer -->

                <!-- Start Modal Deny Transfer -->
                @foreach ($assets as $ass)
                    <div class="modal fade" id="modalReject-{{ $ass->id }}">
                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body text-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                        fill="currentColor" class="bi bi-x-octagon-fill text-danger mb-3 mt-3"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708" />
                                    </svg>
                                    <h4 class="">Reject transfer request ?</h4>
                                    <p class="text-muted mb-3">This action will reject the transfer request.</p>
                                    <a href="{{ route('asset-rejection-process', $ass->id) }}"
                                        class="btn btn-danger btn-sm">Yes, reject</a> <button class="btn btn-light btn-sm"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- End Modal Deny Transfer -->

            </div>
            <!-- Modal Section -->

        </div>
    </div>
    <!-- End -->

    <script type="text/javascript">
        $(document).ready(function() {

            // DATATABLE : ASSET TRANSFER APPROVAL
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 50,
                ajax: "{{ route('asset-transfer-approval-index') }}",
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
                        data: 'item_name',
                        name: 'item_name'
                    },
                    {
                        data: 'trans_description',
                        name: 'trans_description'
                    },
                    {
                        data: 'trans_status',
                        name: 'trans_status',
                    },
                    {
                        data: 'trans_date',
                        name: 'trans_date'
                    },
                    {
                        data: 'transferby',
                        name: 'transfer by',

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
<!-- ASSET TRANSFER APPROVAL MODULE -->
