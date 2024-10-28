<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-theme-mode="light" data-header-styles="gradient"
    data-toggled="close" data-nav-style="menu-hover" style="--primary-rgb: 5, 25, 105;"
    loader="enable"  data-menu-styles="gradient">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AssetTrack | {{ $title }}</title>
    <meta name="Description" content="AssetTrack Management System">
    <meta name="Author" content="Muhammad Zikri Bin Kashim | Zeeke Software Solutions ">


    <!-- Favicon -->
    <link rel="icon" href="../assets/images/brand-logos/logo_tab.png" type="image/x-icon">

    <!-- Choices JS -->
    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Main Theme Js -->
    <script src="../assets/js/main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style Css -->
    <link href="../assets/css/styles.min.css" rel="stylesheet">

    <!-- Icons Css -->
    <link href="../assets/css/icons.css" rel="stylesheet">

    <!-- Node Waves Css -->
    <link href="../assets/libs/node-waves/waves.min.css" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="../assets/libs/simplebar/simplebar.min.css" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="../assets/libs/@simonwep/pickr/themes/nano.min.css">

    <!-- Choices Css -->
    <link rel="stylesheet" href="../assets/libs/choices.js/public/assets/styles/choices.min.css">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">

    <!-- Cleave.js -->
    <script src="../assets/libs/cleave.js/cleave.min.js"></script>

    <!-- Internal form-input-mask JS -->
    <script src="../assets/js/form-input-mask.js"></script>

    <!-- DataTable JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">


    <style>
        @media print {
            .donotprint {
                display: none;
            }

            .print {
                display: block;
            }

            .page-break {
                page-break-before: always;
                margin-bottom: 20px;
            }
        }
    </style>

</head>

<body>


    <!-- Loader -->
    <div id="loader">
        <div class="spinner-border text-primary fs-16" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="fw-semibold ms-2"> Loading... </div>
    </div>
    <!-- Loader -->

    <div class="page">

        @include('Asset-Management.layouts.navbar')
        @include('Asset-Management.layouts.sidebar')
        @yield('content')

    </div>


    <!-- Popper JS -->
    <script src="../assets/libs/@popperjs/core/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Defaultmenu JS -->
    <script src="../assets/js/defaultmenu.min.js"></script>

    <!-- Node Waves JS-->
    <script src="../assets/libs/node-waves/waves.min.js"></script>

    <!-- Sticky JS -->
    <script src="../assets/js/sticky.js"></script>

    <!-- Simplebar JS -->
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/js/simplebar.js"></script>

    <!-- Color Picker JS -->
    <script src="../assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Custom-Switcher JS -->
    <script src="../assets/js/custom-switcher.min.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/custom.js"></script>

    <!-- Modal JS -->
    <script src="../assets/js/modal.js"></script>

    <!-- Date & Time Picker JS -->
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../assets/js/date&time_pickers.js"></script>

    <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script>

    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <!-- Cleave.js -->
    <script src="../assets/libs/cleave.js/cleave.min.js"></script>

    <!-- Internal form-input-mask JS -->
    <script src="../assets/js/form-input-mask.js"></script>

    <!-- Apex Charts JS -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- HRM Dashboard JS -->
    <script src="../assets/js/hrm-dashboard.js"></script>

</body>

</html>

