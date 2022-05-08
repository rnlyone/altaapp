@include('app.app', ['dash_active' => 'active', 'title' => 'Dashboard'])

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row match-height">
                    <!-- Greetings Card starts -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card card-congratulations">
                            <div class="card-body text-center">
                                <img src="/app-assets/images/elements/decore-left.png" class="congratulations-img-left"
                                    alt="card-img-left" />
                                <img src="/app-assets/images/elements/decore-right.png"
                                    class="congratulations-img-right" alt="card-img-right" />
                                <div class="avatar avatar-xl bg-primary shadow">
                                    <div class="avatar-content">
                                        <i data-feather="award" class="font-large-1"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-1 text-white">Selamat Datang {{auth()->user()->name}},</h1>
                                    <p class="card-text m-auto w-75">
                                        Selamat datang di aplikasi Web-test pengujian aplikasi web pembelajaran
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Greetings Card ends -->
                </div>

                @if (auth()->user()->role == 'admin')
                    {{-- mini button start --}}
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="alternatif">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Data Alternatif</p>
                                    </div>
                                    <div class="avatar bg-light-danger p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="database">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="kriteria">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Data Kriteria</p>
                                    </div>
                                    <div class="avatar bg-light-info p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="check-square">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="subkriteria">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Data Sub-Kriteria</p>
                                    </div>
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="check-circle">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="wp">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Data Hitung WP</p>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="file-text">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- mini button end --}}
                    {{-- mini button start --}}
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="owa">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Data Hitung OWA</p>
                                    </div>
                                    <div class="avatar bg-light-danger p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="folder">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="hasil">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Data Hasil Akhir</p>
                                    </div>
                                    <div class="avatar bg-light-info p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="archive">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="user">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">User Management</p>
                                    </div>
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="user">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <a class="card" href="dash">
                                <div class="card-header">
                                    <div>
                                        <p class="card-text fw-bolder">Setting</p>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <img data-feather="settings">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    {{-- mini button end --}}
                @endif


            </section>
            <!-- Dashboard Analytics end -->

        </div>
    </div>
</div>
<!-- END: Content-->

@include('app.footer')
