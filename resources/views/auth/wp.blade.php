@include('app.app', ['wp_active' => 'active', 'title' => 'Weighted Product'])

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
                            <h2 class="content-header-title float-start mb-0">Weighted Product</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="wp">Weighted Product</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics Start -->
            <section class="app-user-list">
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Bobot Kriteria (W) dan Pemangkatan</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table" id="kriteriatable">
                                <thead class="table-light">
                                    <tr>
                                        @foreach ($kritdata as $k)
                                            <th>C{{$k->id}} ({{$k->jenis}})</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($kritdata as $k)
                                            @php
                                                if ($k->jenis == 'benefit') {
                                                    $bobot = ($k->bobot/$kritbobotsum)*1;
                                                } else {
                                                    $bobot = ($k->bobot/$kritbobotsum)*-1;
                                                }
                                            @endphp
                                            <td>{{$bobot}}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- list section start -->
                @foreach ($gdm as $i => $u)
                @php
                        try {
                            $nilaiuser = $nilaidata->where('id_user', $u->id);
                        } catch (\Throwable $th) {
                            $nilaiuser = 0;
                        }
                @endphp
                    <div class="card">
                        <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Matrix GDM {{$i+1}} | {{$u->name}} | {{$u->role}}</h5></div>
                                <div class="dt-action-buttons text-end">
                                </div>
                            </div>
                            <table class="user-list-table table wptable" id="wptable{{$u->id}}">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2">Rank</th>
                                        <th rowspan="2">Name</th>
                                        <th colspan="{{$kritcount}}">Kriteria</th>
                                        <th rowspan="2">Weighting Product</th>
                                    </tr>
                                    <tr>
                                        @foreach ($kritdata as $k)
                                            <th>C{{$k->id}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rankwp[$u->id] as $ir => $r)
                                    @php
                                        $a = $alterdata->where('id', $r)->first();
                                    @endphp
                                        <tr>
                                            <td>{{$ir}}</td>
                                            <td>{{$a->nama}} ({{$a->id}})</td>
                                            @foreach ($kritdata as $k)
                                                @php
                                                    try {
                                                        $kritnilai = $nilaiuser->where('id_alternatif', $a->id)->where('id_kriteria', $k->id)->first()->nilai;
                                                    } catch (\Throwable $th) {
                                                        $kritnilai = 0;
                                                    }
                                                @endphp
                                                <td>{{$kritnilai}}</td>
                                            @endforeach

                                            <td>@if ($wp[$u->id][$a->id] == NAN)
                                                0
                                            @else
                                                {{$wp[$u->id][$a->id]}}
                                            @endif</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <!-- Modal to add new user Ends-->
                    </div>
                @endforeach
                <!-- list section end -->
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
