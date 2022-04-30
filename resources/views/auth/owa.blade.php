@include('app.app', ['owa_active' => 'active', 'title' => 'Ordered Weighting Averaging'])

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
                            <h2 class="content-header-title float-start mb-0">Ordered Weighting Averaging</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="owa">Ordered Weighting Averaging</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics Start -->
            <section class="app-user-list">

                {{-- WP RANKING --}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Weighted Product Ranking Setiap User</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>User</th>
                                        @foreach ($alterdata as $i => $a)
                                            <th>Ranking {{$i+1}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($gdm as $i => $u)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>{{$u->name}}</td>
                                        @foreach ($rankwp[$u->id] as $iwr => $wr)
                                            <td>{{$alterdata->where('id', $wr)->first()->nama}} ({{$alterdata->where('id', $wr)->first()->id}})</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- LQ GDM--}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Linguistic Quantifier (Setiap GDM)</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>User</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($gdm as $i => $u)
                                    <tr>
                                        <td>W{{$i+1}}</td>
                                        <td>{{$u->name}}</td>
                                        <td>{{$gdmwowa[$u->id]}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                {{-- Agregasi Preferensi OWA --}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Matriks Agregasi Preferensi OWA</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Index</th>
                                        @foreach ($alterdata as $ia => $a)
                                            <th>{{$ia+1}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alterdata as $ia => $a)
                                        <tr>
                                            <td>{{$ia+1}}</td>
                                            @foreach ($alterdata as $iwp => $wp)
                                                <td>{{$Agpref[$ia+1][$iwp+1]}}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Normalisasi Agregasi Preferensi OWA --}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Normalisasi Matriks Agregasi Preferensi OWA</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Index</th>
                                        @foreach ($alterdata as $ia => $a)
                                            <th>{{$ia+1}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alterdata as $ia => $a)
                                        <tr>
                                            <td>{{$ia+1}}</td>
                                            @foreach ($alterdata as $iwp => $wp)
                                                <td>{{$NAgpref[$ia+1][$iwp+1]}}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- LQ Alternatif--}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Linguistic Quantifier (Setiap Alternatif)</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Alternatif</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($alterdata as $i => $a)
                                    <tr>
                                        <td>W{{$i+1}}</td>
                                        <td>{{$a->nama}}</td>
                                        <td>{{$alterwowa[$a->id]}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- QGDD OWA --}}
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Quantifier Guided Dominance Degree (QGDD)</h5></div>
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
