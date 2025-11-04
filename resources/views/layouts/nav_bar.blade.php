<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/img/logo-unja.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg text-center p-3">
                <h3 class="text-white">Prediksi KEK <span><img src="{{ asset('assets/img/logo-unja.png') }}" alt=""
                            height="35"></span>
                </h3>

            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/img/logo-unja.png') }}" alt="" height="22">

            </span>
            <span class="logo-lg text-center p-3">
                <h3 class="text-white">Prediksi KEK <span><img src="{{ asset('assets/img/logo-unja.png') }}" alt=""
                            height="35"></span>
                </h3>

            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        </button>

    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDataMaster" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDataMaster">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-data-master">Data Master</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDataMaster">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.soal.index') }}" class="nav-link" data-key="t-soal">
                                    Soal
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.jawaban.index') }}" class="nav-link" data-key="t-jawaban">
                                    Jawaban
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> <!-- end Data Master Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDataSkrining" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDataSkrining">
                        <i class="ri-bar-chart-2-line"></i> <span data-key="t-data-master">Data Skrining</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDataSkrining">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.data.pretest') }}" class="nav-link" data-key="t-pretest">
                                    Pretest
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.data.posttest') }}" class="nav-link" data-key="t-posttest">
                                    Post Test
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.data.skrining') }}" class="nav-link" data-key="t-skrining">
                                    Skrining
                                </a>
                            </li>


                        </ul>
                    </div>
                </li>
                @if (Auth::user()->email == 'admin@gmail.com')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarDataUser" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarDataUser">
                            <i class="ri-file-user-line"></i> <span data-key="t-data-master">Data User</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarDataUser">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link" data-key="t-user">
                                        Add Admin
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </li>
                @endif
            </ul>

        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
