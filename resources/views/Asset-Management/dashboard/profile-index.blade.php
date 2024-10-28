@extends('Asset-Management.layouts.main')

@section('content')
    <!-- Start -->
    <div class="main-content app-content">
        <div class="container">
            <div class="row my-4">

                <!-- Personal Details -->
                <div class="row my-4">
                    <!-- Page Header -->
                    <div class="col-md-4 mb-4">
                        <h6 class="card-title fw-semibold fs-22">My Profile</h6>
                        <p class="card-subtitle mb-3 text-muted fs-12">Update your profile here</p>
                        <div class="ms-md-1 ms-0">
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ Auth::user()->staff_name }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Page Header -->

                    <!-- Personal Details Form Update -->
                    <div class="col-md-8">

                        <!-- Start Alert -->
                        @if (session()->has('success'))
                            <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
                                <svg class="flex-shrink-0 me-2 svg-success" xmlns="http://www.w3.org/2000/svg"
                                    height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
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
                            <form action="{{ route('profile-update-post', $user->id) }}" method="POST">
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        {{-- Code  --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label ">Staff No.</label>
                                            <input type="text" class="form-control" name="staff_no"
                                                id="input-placeholder" value="{{ $user->staff_no }}" readonly disabled>
                                        </div>
                                        {{-- Name --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Full Name <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text" class="form-control" name="staff_name"
                                                id="input-placeholder" value="{{ $user->staff_name }}" required>
                                        </div>
                                        {{-- Phone --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Phone No. <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text" class="form-control" name="staff_phone"
                                                id="input-placeholder" value="{{ $user->staff_phone }}" required>
                                        </div>
                                        {{-- Email --}}
                                        <div class="col-sm-6 mb-2">
                                            <label for="input-placeholder" class="form-label">Email <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="email" class="form-control" name="email" id="input-placeholder"
                                                value="{{ $user->email }}" required>
                                        </div>
                                        {{-- Company --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Company</label>
                                            <input type="text" class="form-control" name="comp_id" id="input-placeholder"
                                                value="{{ $comp }}" readonly disabled>
                                        </div>
                                        {{-- Department --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Department</label>
                                            <input type="text" class="form-control" name="dep_id"
                                                id="input-placeholder" value="{{ $dep }}" readonly disabled>
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
                    <!-- Personal Details Form Update -->

                </div>
                <!-- Personal Details -->

                <!-- Password Setting -->
                <div class="row my-2">
                    <div class="col-md-4 mb-4">
                        <h6 class="card-title fw-semibold fs-22">Change Password</h6>
                        <p class="card-subtitle mb-3 text-muted fs-12">Setting</p>
                    </div>
                    <div class="col-md-8">
                        <div class="card custom-card shadow-sm">
                            <form action="{{ route('password-update-post', $user->id) }}" method="POST">
                                <div class="card-body">
                                    @csrf
                                    <div class="row">
                                        {{-- Current Password  --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label ">Current Password <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control form-control-lg" id="curr-password"
                                                    placeholder="Current Password" type="password" name="currpassword"
                                                    required autocomplete="password">
                                                <button class="btn btn-light" type="button"
                                                    onclick="createpassword('curr-password',this)" id="button-addon2"><i
                                                        class="ri-eye-off-line align-middle"></i></button>
                                            </div>
                                        </div>
                                        {{-- New Password --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">New Password <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control form-control-lg" id="password"
                                                    placeholder="New Password" type="password" name="password" required
                                                    autocomplete="password">
                                                <button class="btn btn-light" type="button"
                                                    onclick="createpassword('password',this)" id="button-addon2"><i
                                                        class="ri-eye-off-line align-middle"></i></button>
                                            </div>
                                        </div>
                                        {{-- Confirm --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">Confirm Password <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control form-control-lg" id="confirm-password"
                                                    placeholder="Confirm Password" type="password" name="cpassword"
                                                    required autocomplete="password">
                                                <button class="btn btn-light" type="button"
                                                    onclick="createpassword('confirm-password',this)"
                                                    id="button-addon2"><i
                                                        class="ri-eye-off-line align-middle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-light">
                                        <i class='bx bxs-check-circle me-2 align-middle fs-18 text-primary'></i>Update Password</button>
                                </div>

                            </form>
                        </div>


                    </div>
                </div>
                <!-- Password Setting -->

                <!-- Account Setting -->
                <div class="row my-2">
                    <div class="col-md-4 mb-4">
                        <h6 class="card-title fw-semibold fs-22">Account</h6>
                        <p class="card-subtitle mb-3 text-muted fs-12">Setting</p>
                    </div>
                    <div class="col-md-8">
                        <div class="card custom-card shadow-sm">

                            <div class="card-body">
                                <a type="submit" class="btn btn-danger" href="{{ route('logout-process') }}">
                                    Log Out</a>
                            </div>



                        </div>


                    </div>
                </div>
                <!-- Account Setting -->

            </div>

        </div>
    </div>
    <!-- End -->
    @include('Asset-Management.layouts.footer')
@endsection
<!-- FULL CHECKED BY MUHAMMAD ZIKRI BIN KASHIM ON 12-07-2024 -->
<!-- MY PROFILE MODULE -->