<?php
use App\Models\Company;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="light" data-toggled="close" data-nav-style="menu-hover" style="--primary-rgb: 0, 74, 173;">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Asset Track | Log In </title>
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
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="page justify-content-center align-items-center">
        <div class="container">
            <!-- Content -->
            <div class="row justify-content-center align-items-center">

                @if (Company::count() >= 1)
                    <div class="col-md-6 d-sm-block d-none">
                        <p class="card-subtitle text-muted fs-12">Ames Hotel</p>
                        <h6 class="card-title fw-normal fs-30">Welcome to <span class="">Asset</span><span
                                class=" text-primary">.Track</span></h6>
                        <p class="card-subtitle text-muted fs-12">Please log in using valid credentials.</p>
                    </div>
                    <!-- Login Form -->
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
                                <p class="h5 fw-semibold mb-3 mt-3 text-center">Log In</p>
                                <form method="POST" action="{{ route('auth-process') }}">
                                    @csrf
                                    <div class="row gy-3 my-5">
                                        <div class="col-xl-12 mt-0">
                                            <label for="signin-username" class="form-label text-default">Staff
                                                Email</label>
                                            <input class="form-control form-control-lg" id="signin-username"
                                                placeholder="Staff Email" type="email" name="email"
                                                :value="old('email')" required autofocus autocomplete="email">
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <label for="signin-password"
                                                class="form-label text-default d-block">Password
                                            </label>
                                            <div class="input-group">
                                                <input class="form-control form-control-lg" id="signin-password"
                                                    placeholder="Password" type="password" name="password" required
                                                    autocomplete="password">
                                                <button class="btn btn-light" type="button"
                                                    onclick="createpassword('signin-password',this)"
                                                    id="button-addon2"><i
                                                        class="ri-eye-off-line align-middle"></i></button>
                                            </div>

                                        </div>
                                        <div class="col-xl-12 d-grid ">
                                            <button type="submit" class="btn btn-lg btn-primary-gradient">Log
                                                In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- Login Form -->
                @else
                    <!-- Installation Process-->
                    <div class=" col-sm-12 col-md-8 mt-5">

                        @if (session()->has('success'))
                            <div class="alert alert-success d-flex align-items-center alert-dismissible"
                                role="alert">
                                <svg class="flex-shrink-0 me-2 svg-success" xmlns="http://www.w3.org/2000/svg"
                                    height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
                                    <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none" />
                                    <path
                                        d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" />
                                </svg>
                                <div>
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="bi bi-x"></i></button>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger d-flex align-items-center alert-dismissible"
                                role="alert">
                                <svg class="flex-shrink-0 me-2 svg-danger" xmlns="http://www.w3.org/2000/svg"
                                    enable-background="new 0 0 24 24" height="1.5rem" viewBox="0 0 24 24"
                                    width="1.5rem" fill="#000000">
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"><i class="bi bi-x"></i></button>
                            </div>
                        @endif

                        <div class="card custom-card shadow-lg mt-5">
                            <div class="card-header">
                                <div class="card-title">Getting Started !</div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <img src="../assets/images/brand-logos/logo_login.png" alt="logo"
                                        width="180px">
                                </div>
                                <div class="text-muted text-center fs-10">Version: 2.5</div>
                                <p class="text-dark fw-semibold text-center">Welcome to <span
                                        class="text-primary fw-semibold">AssetTrack</span> Management System !</p>
                                <p class="text-dark">
                                    Before you begin using the system, you need to
                                    insert all prerequisite data. Please follow these instructions carefully to ensure a
                                    smooth setup process.
                                </p>
                                <ol>
                                    <li class="text-dark fw-bold">
                                        Login Using Given Credentials

                                        <div class=" fw-normal"><span class="text-danger fw-bold">*
                                            </span>Email: admin01@assettrack.my</div>
                                        <div class=" fw-normal"><span class="text-danger fw-bold">*
                                            </span>Password: assettrack@1234</div>
                                    </li>
                                    <li class="text-dark fw-bold">
                                        Initial Setup Steps

                                        <div class=" fw-normal">
                                            <span class="text-danger fw-bold">* </span>Update Company Details: Ensure
                                            all
                                            relevant company information is accurate and complete.
                                        </div>
                                        <div class=" fw-normal">
                                            <span class="text-danger fw-bold">* </span>Update Department Details: Enter
                                            the
                                            details for each department within your company.
                                        </div>
                                    </li>
                                    <li class="text-dark fw-bold">
                                        Important Note !

                                        <div class=" fw-normal">
                                            <span class=" fw-bold">* </span> <span class="fw-bold text-danger">Do
                                                Not</span> remove the given admin credentials. You may update the
                                            details as
                                            needed, but please retain the original admin account for system integrity.
                                        </div>
                                    </li>
                                </ol>

                                <p class="text-dark">Thank you for your attention to detail in completing this setup.
                                    We are confident that the <span class="text-primary fw-semibold">AssetTrack</span>
                                    Management System will greatly enhance your asset management capabilities.</p>

                                <p class="text-dark fw-semibold">System manual :</p>

                                <div class="d-flex justify-content-center align-items-md-baseline">
                                    <a href="../Manual/Assettrack_Admin_Manual.pdf"
                                        class="btn btn-sm btn-primary-transparent me-2" download><i
                                            class='bx bxs-download me-2 align-middle d-inline-block'></i>Admin
                                        Manual</a>
                                    <a href="../Manual/Assettrack_Staff_Manual.pdf"
                                        class="btn btn-sm btn-primary-transparent me-2" download><i
                                            class='bx bxs-download me-2 align-middle d-inline-block'></i>Staff
                                        Manual</a>
                                    <a href="../Manual/Assettrack_Viewer_Manual.pdf"
                                        class="btn btn-sm btn-primary-transparent me-2" download><i
                                            class='bx bxs-download me-2 align-middle d-inline-block'></i>
                                        Viewer Manual</a>


                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end align-items-end">
                                    <a href="{{ route('installation-system') }}"
                                        class="btn btn-primary-gradient switcher-icon">
                                        <i class="bx bx-cog header-link-icon"></i>
                                        Start Installation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Installation Process-->
                @endif
            </div>
            <!-- Content -->
        </div>
    </div>


    <footer class="mt-auto py-3 bg-white text-center donotprint">

        <span class="text-muted"> Copyright © <span id="year">2024</span> <a href="javascript:void(0);"
                class="text-primary fw-semibold">AssetTrack V2.5</a>.</a> All rights reserved
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
