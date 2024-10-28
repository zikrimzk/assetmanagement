<?php
use App\Models\Department;
use App\Models\Area;
use App\Models\Staff;
use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\AssetItem;
use App\Models\System;

?>
@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container">

            <!-- Start::page-header -->

            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb ">
                @if (Auth::user()->staff_role == 1)
                    <div>
                        <p class="fw-semibold fs-18 mb-0 donotprint">Welcome back, {{ Auth::user()->staff_name }} !</p>
                    </div>
                    <div class="btn-list mt-md-0 mt-2 donotprint">
                        <button type="button" class="btn btn-primary-transparent btn-sm" onclick="window.print()">
                            <i class="ri-upload-cloud-line me-2 align-middle d-inline-block"></i>Print Report
                        </button>
                        <a href="{{ route('downloadsql') }}" class="btn btn-danger-transparent btn-sm">
                            <i class='bx bxs-download me-2 align-middle d-inline-block'></i>Download Backup (SQL)
                        </a>
                        <a href="../Manual/AssetTrack_Admin_Manual.pdf" class="btn btn-primary-transparent btn-sm"
                            target="_blank">
                            <i class='bx bxs-download me-2 align-middle d-inline-block'></i>Download Manual
                        </a>
                    </div>
                @elseif(Auth::user()->staff_role == 2)
                    <div>
                        <p class="fw-semibold fs-18 mb-0 donotprint">Hi, {{ Auth::user()->staff_name }} !</p>

                    </div>
                    <div class="btn-list mt-md-0 mt-2 donotprint">
                        <a href="../Manual/AssetTrack_Staff_Manual.pdf" class="btn btn-primary-transparent btn-sm"
                            target="_blank">
                            <i class='bx bxs-download me-2 align-middle d-inline-block'></i>Download Manual
                        </a>
                    </div>
                @elseif(Auth::user()->staff_role == 3)
                    <div>
                        <p class="fw-semibold fs-18 mb-0 donotprint">Hi, {{ Auth::user()->staff_name }} !</p>
                    </div>
                    <div class="btn-list mt-md-0 mt-2 donotprint">
                        <a href="../Manual/AssetTrack_Viewer_Manual.pdf" class="btn btn-primary-transparent btn-sm"
                            target="_blank">
                            <i class='bx bxs-download me-2 align-middle d-inline-block'></i>Download Manual
                        </a>
                    </div>
                @elseif(Auth::user()->staff_role == 5)
                    <div>
                        @if (DB::table('systems')->latest()->first()->system_status == 0)
                            <p class="fw-semibold fs-18 mb-0 donotprint">System Status : <span
                                    class="fw-bold text-danger">DEACTIVATED</span></p>
                        @elseif(DB::table('systems')->latest()->first()->system_status == 1)
                            <p class="fw-semibold fs-18 mb-0 donotprint">System Status : <span
                                    class="fw-bold text-success">ACTIVE</span></p>
                        @endif

                    </div>
                    <div class="btn-list mt-md-0 mt-2 donotprint">
                        <a href="{{ route('systemupdown') }}" class="btn btn-danger-transparent btn-sm">
                            System Active/Deactivate
                        </a>
                        <a href="{{ route('downloadsql') }}" class="btn btn-danger-transparent btn-sm">
                            <i class='bx bxs-download me-2 align-middle d-inline-block'></i>Download Backup (SQL)
                        </a>
                    </div>
                @endif
            </div>

            <!-- End::page-header -->

            @if (Auth::user()->staff_role == 1 || Auth::user()->staff_role == 5)
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

                <!-- Company Summary -->
                <div class="row donotprint">
                    <h6 class="card-title fw-semibold fs-18">Company</h6>
                    <p class="card-subtitle mb-3 text-muted fs-12">Summary</p>

                    <div class="col-sm-12 col-md-6 donotprint">
                        <div class="card custom-card shadow-sm">
                            <div class="card-header">
                                <div class="card-title">Staff By Company</div>
                            </div>
                            <div class="card-body">
                                {!! $chartstaffcomp->container() !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-6">
                        {{-- Total Department --}}
                        <div class="card custom-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-2">Total Departments</p>
                                    <h4 class="mb-0 fw-semibold mb-2">
                                        {{ Department::count() }}
                                    </h4>
                                    <span class="fs-12 mb-0"><a href="{{ route('department-index') }}"
                                            class="text-primary ">View All <i
                                                class='bx bxs-chevrons-right align-middle me-2'></i></a> </span>
                                </div>
                                <div>
                                    <span class="avatar avatar-md bg-success p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            fill="currentColor" class="bi bi-person-video3 svg-white success"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2" />
                                            <path
                                                d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783Q16 12.312 16 12V4a2 2 0 0 0-2-2z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- Total Area --}}
                        <div class="card custom-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-2">Total Areas</p>
                                    <h4 class="mb-0 fw-semibold mb-2">
                                        {{ Area::count() }}
                                    </h4>
                                    <span class="fs-12 mb-0"><a href="{{ route('area-index') }}"
                                            class="text-primary ">View
                                            All <i class='bx bxs-chevrons-right align-middle me-2'></i></a> </span>
                                </div>
                                <div>
                                    <span class="avatar avatar-md bg-warning p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            fill="currentColor" class="bi bi-pin-map-fill svg-white warning"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8z" />
                                            <path fill-rule="evenodd"
                                                d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- Total All Staff --}}
                        <div class="card custom-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-2">Total Staff</p>
                                    <h4 class="mb-0 fw-semibold mb-2">
                                        {{ Staff::where('staff_status', '!=', 3)->count() }}
                                    </h4>
                                    <span class="fs-12 mb-0"><a href="{{ route('staff-index') }}"
                                            class="text-primary ">View All <i
                                                class='bx bxs-chevrons-right align-middle me-2'></i></a> </span>

                                </div>
                                <div>
                                    <span class="avatar avatar-md bg-info p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-white secondary"
                                            height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path
                                                d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2m0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2m0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-break"></div>

                <!-- Asset Summary -->
                <div class="row">
                    <h6 class="card-title fw-semibold fs-18">Asset Report</h6>
                    <p class="card-subtitle mb-3 text-muted fs-12">Summary</p>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-6">
                        {{-- Total All Asset --}}
                        <div class="card custom-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-2">Total Assets</p>
                                    <h4 class="mb-0 fw-semibold mb-2">
                                        {{ Asset::count() }}
                                    </h4>
                                    <span class="fs-12 mb-0"><a href="{{ route('asset-index') }}"
                                            class="text-primary donotprint">View All <i
                                                class='bx bxs-chevrons-right align-middle me-2'></i></a> </span>
                                </div>
                                <div>
                                    <span class="avatar avatar-md bg-primary p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            fill="currentColor" class="bi bi-journal-text svg-white success"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                                            <path
                                                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                            <path
                                                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- Total Asset Transfer --}}
                        <div class="card custom-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-2">Total Asset Transfers</p>
                                    <h4 class="mb-0 fw-semibold mb-2">
                                        {{ AssetTransfer::where('trans_status', '2')->count() }}
                                    </h4>
                                    <span class="fs-12 mb-0">There are <span
                                            class="badge bg-danger-transparent text-danger mx-1">{{ AssetTransfer::where('trans_status', '1')->count() }}</span>
                                        request requires approval</span>
                                </div>
                                <div>
                                    <span class="avatar avatar-md bg-danger p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            fill="currentColor" class="bi bi-journal-check svg-white primary"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                            <path
                                                d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                            <path
                                                d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- Total Asset Item --}}
                        <div class="card custom-card">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-2">Total Asset Value</p>
                                    <h4 class="mb-0 fw-semibold mb-2">
                                        @foreach ($totalassetvalue as $tav)
                                            RM {{ $tav->totalcost }}
                                        @endforeach
                                    </h4>
                                </div>
                                <div>
                                    <span class="avatar avatar-md bg-info p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="svg-white secondary"
                                            enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24"
                                            width="24px" fill="#000000">
                                            <path d="M0,0h24v24H0V0z" fill="none" />
                                            <g>
                                                <path
                                                    d="M19.5,3.5L18,2l-1.5,1.5L15,2l-1.5,1.5L12,2l-1.5,1.5L9,2L7.5,3.5L6,2v14H3v3c0,1.66,1.34,3,3,3h12c1.66,0,3-1.34,3-3V2 L19.5,3.5z M15,20H6c-0.55,0-1-0.45-1-1v-1h10V20z M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z" />
                                                <rect height="2" width="6" x="9" y="7" />
                                                <rect height="2" width="2" x="16" y="7" />
                                                <rect height="2" width="6" x="9" y="10" />
                                                <rect height="2" width="2" x="16" y="10" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 donotprint">
                        <div class="card custom-card shadow-sm">
                            <div class="card-header">
                                <div class="card-title">Asset By Company</div>
                            </div>
                            <div class="card-body">
                                {!! $chartassetcomp->container() !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 donotprint">
                        <div class="card custom-card shadow-sm">
                            <div class="card-body">
                                {!! $chartassetvalue->container() !!}
                            </div>
                        </div>
                    </div>

                    <div class="page-break"></div>

                    @foreach ($type as $t)
                        <p class=" fw-semibold mb-3 text-primary fs-16">{{ $t->type_name }}</p>
                        @foreach ($item as $it)
                            @if ($t->id == $it->type_id)
                                <div class="col-sm-6 col-md-3">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xxl-9 col-xl-10 col-lg-9 col-md-9 col-sm-8 col-8 px-0">
                                                    <div class="mb-2 fs-14 fw-semibold">{{ $it->item_name }} <span
                                                            class="text-muted fs-12">({{ $it->item_code }})</span></div>
                                                    <div class="text-muted mb-1 fs-12">
                                                        <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom">
                                                            {{ $it->item_count }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <span class="fs-12 mb-0">Total Cost : <span
                                                                class="fw-semibold text-primary mx-1">RM
                                                                {{ $it->itemcost }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="page-break"></div>
                    @endforeach




                </div>
            @elseif(Auth::user()->staff_role == 2)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-center align-item-center">
                            <img src="../assets/images/media/banner_staff.png" class="img-fluid" width="800px"
                                alt="home-banner">
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-center align-item-center">
                            <img src="../assets/images/media/banner_viewer.png" class="img-fluid" width="800px"
                                alt="home-banner">
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <!-- End::app-content -->

    @include('Asset-Management.layouts.footer')

    <script src="{{ $chartassetcomp->cdn() }}"></script>
    {{ $chartassetcomp->script() }}

    <script src="{{ $chartstaffcomp->cdn() }}"></script>
    {{ $chartstaffcomp->script() }}

    <script src="{{ $chartassetvalue->cdn() }}"></script>
    {{ $chartassetvalue->script() }}
@endsection
