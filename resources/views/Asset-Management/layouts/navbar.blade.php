<!-- header -->
<header class="app-header donotprint">
    <div class="main-header-container container-fluid">

        <!-- content-left -->
        <div class="header-content-left">

            <!-- Logo -->
            <div class="header-element">
                <div class="d-flex align-items-center">
                    <div class="d-sm-block d-none">
                        <img src="../assets/images/brand-logos/logo_generals.png" alt="logo" width="180px">
                    </div>

                </div>
            </div>
            <!-- Logo -->

            <!-- Sidemenu Button -->
            <div class="header-element">
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            </div>
            <!-- Sidemenu Button -->

        </div>
        <!-- content-left -->


        <!-- content-right -->
        <div class="header-content-right">

            <!-- User Profile -->
            <div class="header-element">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">

                            <i class='bx bxs-user-circle rounded-circle fs-32'></i>
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{ Auth::user()->staff_name }}</p>
                            <span class="op-7 fw-normal d-block fs-11">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </a>
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex" href="{{ route('profile-index') }}"><i
                                class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile</a></li>
                    <li><a class="dropdown-item d-flex" href="{{ route('logout-process') }}"><i
                                class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                </ul>
            </div>
            <!-- User Profile -->

        </div>
        <!-- content-right -->

    </div>
</header>
<!-- header -->
