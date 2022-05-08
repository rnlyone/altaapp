@include('app.app', ['hasil_active' => 'active', 'title' => 'Hasil Akhir'])

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            {{-- directory content --}}
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Hasil Akhir</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="hasil">Hasil Akhir</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics Start -->
            <section class="app-user-list">

                {{-- QGDD OWA --}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Hasil Akhir Pemeringkatan Alternatif Pembelajaran</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Rank</th>
                                        <th>Alternatif</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($QGDD as $i => $item)
                                        <tr>
                                            <td>{{$index}}</td>
                                            <td>{{$alterdata->where('id', $i)->first()->nama}} ({{$alterdata->where('id', $i)->first()->id}})</td>
                                            <td>{{$item}}</td>
                                        </tr>
                                        @php
                                            $index++
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Kesimpulan --}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Kesimpulan</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            @php
                                use App\Http\Controllers\WPController;
                                $rank = WPController::array_rank($QGDD)
                            @endphp
                            <p>Solusi akhir diperoleh alternatif terbaik adalah aplikasi web pembelajaran <span class="fw-bolder">{{$alterdata->where('id', $rank[$altercount])->first()->nama}}</span>
                                karena memiliki nilai terkecil atau terdapat kesalahan yang minim setelah dilakukan pengujian aplikasi web sehingga disimpulkan bahwa aplikasi web pembelajaran
                                <span class="fw-bolder">{{$alterdata->where('id', $rank[$altercount])->first()->nama}}</span> di rekomendasikan ke pihak sekolah. </p>
                        </div>
                    </div>
                </div>

            </section>
            @if (session()->get('success'))
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Sukses</h4>
                <div class="alert-body">
                    {{session('success')}}
                </div>
              </div>
            @elseif (session()->get('error'))
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Error</h4>
                <div class="alert-body">
                    {{session('error')}}
                </div>
              </div>
            @endif

        </div>
    </div>
</div>

{{-- MODAL --}}


{{-- MODAL END --}}


<!-- END: Content-->
@include('app.footer')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script>

    $(document).ready(function(){
        const table = $('.wptable').DataTable({
            searching: false,
            paging: false,
            info: false,
        })
        });
</script>
