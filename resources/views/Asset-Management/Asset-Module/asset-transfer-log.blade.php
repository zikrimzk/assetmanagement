@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start -->
    <div class="main-content app-content">
        <div class="container">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-22 mb-0">Transfer Log</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);" style="color: rgb(0, 51, 153)">Asset</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('asset-index') }}"
                                    style="color: rgb(0, 51, 153)">Asset Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Asset Transfer Log</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <div class="mt-2 d-flex">
                <a href="{{ route('asset-transfer-approval-index') }}" class="btn btn-primary-transparent btn-sm">
                    <i class='bx bxs-left-arrow-circle me-2 align-middle d-inline-block'></i>Back
                </a>
            </div>
            <!-- Page Header -->

            <!-- Datatable -->
            <div class="row my-3">
                <div class="col-md-12">
                    <div class="card custom-card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap data-table table-hover" id="responsiveDataTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Coding</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Transfer Status</th>
                                            <th scope="col">Transfer by</th>
                                            <th scope="col">Verified by</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Datatable -->
        </div>
    </div>
    <!-- End -->

    <script type="text/javascript">
        $(document).ready(function() {
            // DATATABLE : ASSET LOG
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 100,
                ajax: "{{ route('asset-transfer-log-index') }}",
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
                        data: 'trans_status',
                        name: 'trans_status',
                    },

                    {
                        data: 'transferby',
                        name: 'transferby',

                    },
                    {
                        data: 'approvedby',
                        name: 'approvedby',

                    },
                    {
                        data: 'trans_description',
                        name: 'trans_description'
                    },
                    {
                        data: 'trans_date',
                        name: 'trans_date'
                    },
                ]

            });
        });
    </script>

    @include('Asset-Management.layouts.footer')
@endsection
<!-- FULL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 12-07-2024 -->
<!-- ASSET TRANSFER LOG MODULE -->
