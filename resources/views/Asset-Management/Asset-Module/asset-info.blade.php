<?php
use Carbon\Carbon;
?>
@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start-->
    <div class="main-content app-content">
        <div class="container">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <a href="{{ route('asset-index') }}" class="btn btn-primary-transparent btn-sm donotprint">
                    <i class='bx bxs-left-arrow-circle me-2 align-middle d-inline-block'></i>Back
                </a>

                <div class="ms-md-1 ms-0 donotprint">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Asset</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $ass->item_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header -->

            <!-- Setting -->
            @if (Auth::user()->staff_role != 3)
                <div class="d-flex justify-content-end align-items-center donotprint my-2">
                    <button type="button" onclick="window.print()" class="btn btn-primary btn-sm me-2 donotprint">
                        <i class="ri-upload-cloud-line me-2 align-middle d-inline-block"></i>Print Certificate
                    </button>
                    <a href="{{ route('asset-download-qr', $ass->id) }}" class="btn btn-primary btn-sm  me-2 donotprint">
                        <i class='bx bx-qr me-2 align-middle d-inline-block'></i>
                        Print QR Code</a>
                </div>
            @endif
            <!-- Setting -->


            <!-- Content -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="fs-26 fw-semibold mb-4">{{ $ass->item_name }} <span
                                            class="fs-16 fw-semibold mb-4 text-muted">({{ $ass->item_code }})</span>
                                    </p>
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ route('asset-info-index', $ass->id) }}&amp;size=100x100"
                                        alt="item-qr-code" title="{{ $ass->asset_code }}"
                                        class="img-fluid border border-2" />
                                </div>
                                <p class="fs-18 fw-semibold mb-2">Asset Details</p>
                                <div class="row my-3">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <tbody>
                                                    @if ($ass->asset_image)
                                                        <tr>
                                                            <th scope="row" class="fw-semibold"></th>
                                                            <td> <img src="../storage/{{ $ass->asset_image }}"
                                                                    alt="gmbar" class=" img-fluid" width="200px">
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Code
                                                        </th>
                                                        <td>{{ $ass->asset_code }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Asset Item
                                                        </th>
                                                        <td>{{ $ass->item_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Brand
                                                        </th>
                                                        <td>{{ $ass->asset_brand }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Serial No.
                                                        </th>
                                                        <td>{{ $ass->asset_serialno }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Cost
                                                        </th>
                                                        <td>

                                                            @if ($ass->asset_cost == '')
                                                                N/A
                                                            @else
                                                                RM{{ $ass->asset_cost }}
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Market Value
                                                        </th>
                                                        <td>
                                                            @if ($ass->asset_marketval == '')
                                                                N/A
                                                            @else
                                                                RM{{ $ass->asset_marketval }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Date of Purchase
                                                        </th>
                                                        <td>{{ Carbon::parse($ass->asset_date)->format('d/m/Y') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Remarks
                                                        </th>
                                                        <td>{{ $ass->asset_remarks }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <p class="fs-18 fw-semibold mb-2">Location </p>
                                <div class="row my-3">
                                    <div class="col-xl-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Company
                                                        </th>
                                                        <td>{{ $ass->company_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Department
                                                        </th>
                                                        <td>{{ $ass->department_name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="fw-semibold">
                                                            Area
                                                        </th>
                                                        <td>{{ $ass->area_name }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="mb-3 donotprint">

                                <p class="fs-18 fw-semibold mb-2">Transfer History</p>
                                @if ($transfercount > 0)
                                    <div class="row">
                                        @foreach ($transfer as $trans)
                                            <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-xxl-0 mt-3">
                                                <div class="border p-3">
                                                    <div class="d-sm-flex d-block align-items-top mb-3">
                                                        <div class="d-flex flex-fill">
                                                            <div class="lh-1 me-2">
                                                                <p class="mb-1 fw-semibold fs-14">{{ $trans->transferby }}
                                                                </p>
                                                                <div class="fs-11 text-muted">
                                                                    Transfer on {{ $trans->trans_date }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ps-sm-0 mt-sm-0 mt-3 ps-sm-0 ps-2">
                                                            @if ($trans->trans_status == 2)
                                                                <span class="badge bg-success">Verified by
                                                                    {{ $trans->approvedby }}</span>
                                                            @endif


                                                        </div>
                                                    </div>
                                                    <div class="ps-sm-4 ps-0 mb-3">
                                                        <p class="fw-semibold mb-1 ps-2">Transfer Description</p>
                                                        <p class="mb-0 fs-12 text-muted ps-2">
                                                            {{ $trans->trans_description }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="fs-12 text-muted mb-2">No transfer had been made. </p>
                                @endif
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- Content -->

        </div>
    </div>
    <!-- End -->
    @include('Asset-Management.layouts.footer')
@endsection
<!-- FINAL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 10-07-2024 -->
<!-- ASSET CERTIFICATE MODULE -->
