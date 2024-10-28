@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start-->
    <div class="main-content app-content">
        <div class="container">
            <div class="row my-4">
                <!-- Page Header-->
                <div class="col-md-4 mb-4">
                    <h6 class="card-title fw-semibold fs-22">Company Profile</h6>
                    <p class="card-subtitle mb-3 text-muted fs-12">Update</p>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Company</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Company Profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header-->

                <!-- Form and Setting -->
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
                        <form action="{{ route('company-edit-post', $comp->id) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    {{-- Name --}}
                                    <div class="col-sm-5 mb-2">
                                        <label for="input-placeholder" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="company_name"
                                            id="input-placeholder" required value="{{ $comp->company_name }}">
                                    </div>
                                    {{-- Code  --}}
                                    <div class="col-sm-3 mb-2">
                                        <label for="input-placeholder" class="form-label ">Code </label>
                                        <input type="text" class="form-control" name="company_code"
                                            id="input-placeholder" required value="{{ $comp->company_code }}">
                                    </div>
                                    {{-- Registration No  --}}
                                    <div class="col-sm-4 mb-2">
                                        <label for="input-placeholder" class="form-label ">Registration No </label>
                                        <input type="text" class="form-control" name="company_registno"
                                            id="input-placeholder" value="{{ $comp->company_registno }}">
                                    </div>
                                    {{-- Email --}}
                                    <div class="col-sm-6 mb-2">
                                        <label for="input-placeholder" class="form-label ">Email</label>
                                        <input type="email" class="form-control" name="company_email"
                                            id="input-placeholder" required value="{{ $comp->company_email }}">
                                    </div>
                                    {{-- Phone No --}}
                                    <div class="col-sm-6 mb-2">
                                        <label for="input-placeholder" class="form-label ">Phone No </label>
                                        <input type="text" class="form-control" name="company_phone"
                                            id="input-placeholder" required value="{{ $comp->company_phone }}">
                                    </div>
                                    {{-- Address --}}
                                    <div class="col-sm-12 mb-2">
                                        <label for="input-placeholder" class="form-label ">Address </label>
                                        <textarea type="text" class="form-control" name="company_address" id="input-placeholder">{{ $comp->company_address }}</textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" class="btn btn-light">
                                    <i class='bx bxs-check-circle me-2 align-middle fs-18 text-primary'></i>Save
                                    Changes</button>
                            </div>

                        </form>

                    </div>


                </div>
                <!-- Form and Setting -->
            </div>
        </div>
    </div>
    <!-- End -->
    @include('Asset-Management.layouts.footer')
@endsection
<!-- FINAL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 04-07-2024 -->
<!-- COMPANY PROFILE MODULE -->