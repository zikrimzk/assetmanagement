<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="light" data-toggled="close" data-nav-style="menu-hover" style="--primary-rgb: 0, 74, 173;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Asset Track | First Time Login </title>
    <meta name="Description" content="iAssets Management System Login Page">
    <meta name="Author" content="Muhammad Zikri Bin Kashim | UTeM ">


    <!-- Favicon -->
    <link rel="icon" href="../assets/images/brand-logos/logo_tab.png" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="../assets/js/authentication-main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link href="../assets/css/styles.min.css" rel="stylesheet">

    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet">


    <link rel="stylesheet" href="../assets/libs/swiper/swiper-bundle.min.css">

</head>

<body>
    <header class="app-header">
        <div class="main-header-container container-fluid">
            <div class="header-content-left">
                <div class="header-element">
                    <div class="d-flex align-items-center">
                        <img src="../assets/images/brand-logos/logo_login.png" alt="logo" width="180px">
                        {{-- <p class="text-primary fw-semibold fs-18">i-Asset<span style="color:grey">Track</span></p> --}}
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="page justify-content-center align-items-center">
        <div class="container">
            <!-- Content -->
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 d-sm-block d-none">
                    <h6 class="card-title fw-normal fs-22"> <span
                            class=" text-primary">Hi </span> {{ $staff->staff_name }}  !</h6>
                    <p class="card-subtitle text-muted fs-12">Please change your password for account activation.</p>
                </div>
                <div class=" col-sm-12 col-md-4">
                    
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

                    <div class="card custom-card shadow-lg">
                        <div class="card-body">
                            <p class="h5 fw-semibold mb-3 mt-3 text-center">First Time Login</p>
                            <form action="{{ route('first-time-process',$staff->id) }}" method="POST">
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
                                                    onclick="createpassword('curr-password',this)"
                                                    id="button-addon2"><i
                                                        class="ri-eye-off-line align-middle"></i></button>
                                            </div>
                                        </div>
                                        {{-- New Password --}}
                                        <div class="col-sm-12 mb-2">
                                            <label for="input-placeholder" class="form-label">New Password <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control form-control-lg" id="password"
                                                    placeholder="New Password" type="password" name="password"
                                                    required autocomplete="password">
                                                <button class="btn btn-light" type="button"
                                                    onclick="createpassword('password',this)" id="button-addon2"><i
                                                        class="ri-eye-off-line align-middle"></i></button>
                                            </div>
                                        </div>
                                        {{-- Confirm --}}
                                        <div class="col-sm-12 ">
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
                                        <div class="col-xl-12 d-grid ">
                                            <button type="submit" class="btn btn-lg btn-primary-gradient">Update Password</button>
                                        </div>
                                </div>

                            </form>
                            
                        </div>
                    </div>


                </div>
            </div>
            <!-- Content -->
        </div>
    </div>


    <footer class="mt-auto py-3 bg-white text-center donotprint">

        <span class="text-muted"> Copyright © <span id="year">2024</span> <a href="javascript:void(0);"
                class="text-primary fw-semibold">Asset.Track</a>.</a> All rights reserved
        </span>

    </footer>

    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Swiper JS -->
    <script src="../assets/libs/swiper/swiper-bundle.min.js"></script>

    <!-- Internal Sing-Up JS -->
    <script src="../assets/js/authentication.js"></script>

    <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script>

</body>

</html>
