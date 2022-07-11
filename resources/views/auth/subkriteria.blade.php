@include('app.app', ['subkriteria_active' => 'active', 'title' => 'Data Sub-Kriteria'])
@php
    use App\Models\Subkriteria;
@endphp
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
                            <h2 class="content-header-title float-start mb-0">Data Sub-Kriteria</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="Kriteria">Data Sub-Kriteria</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics Start -->
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <div class="alert-body">
                        {{$error}}
                    </div>
                  </div>
                @endforeach
                @endif
            @if ($kriteriadata == $subsdata)
            <div class="card">
                <div style="margin: 10pt">
                    <div class="card-datatable table-responsive pt-0">
                        <div class="card-header p-0">
                            <div class="head-label"><h5 class="mt-1">Tidak Ada Kriteria</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @foreach ($kriteriadata as $krd)
            <section class="app-user-list">
                <!-- list section start -->
                <div class="card">
                    <div style="margin: 10pt">
                        <div class="card-datatable table-responsive pt-0">
                            <div class="card-header p-0">
                                <div class="head-label"><h5 class="mt-1">Sub-Kriteria {{$krd->nama}} (C{{$krd->id}})</h5></div>
                                <div class="dt-action-buttons text-end">
                                    <button data-toggle="modal" data-bs-toggle="modal" data-bs-target="#tambah-subkriteria{{$krd->id}}" href="javascript:void(0)" class="btn btn-success" id="tombol-tambah">
                                        <i data-feather='plus'></i>
                                    </button>
                                </div>
                            </div>
                            <table class="user-list-table table subTable" id="C{{$krd->id}}table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subdata = Subkriteria::where('id_kriteria', $krd->id)->get();

                                        $num = 1;
                                    @endphp
                                    @foreach ($subdata as $sbd)
                                        <tr>
                                            <td>{{$num}}</td>
                                            <td>{{$sbd->nama}}</td>
                                            <td>{{$sbd->nilai}}</td>
                                            <td>
                                                <button data-toggle="modal" data-bs-toggle="modal" data-original-title="Edit" type="button" data-bs-target="#modaleditsub{{$sbd->id}}" type="button" class="edit-post btn btn-icon btn-success">
                                                    <i data-feather="edit-3"></i>
                                                </button>
                                                <button data-toggle="modal" data-bs-toggle="modal" name="delete" data-original-title="delete" data-bs-target="#modaldel{{$sbd->id}}" type="button" class="delete btn btn-icon btn-outline-danger">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $num++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- modal tambah kriteria --}}
                <div class="modal fade text-start" id="tambah-subkriteria{{$krd->id}}" tabindex="-1" aria-labelledby="myModalLabel1"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel1">Tambah Sub-Kriteria {{$krd->nama}} (C{{$krd->id}})</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="subkriteria/store" method="post">
                                @csrf
                                <div class="modal-body">
                                    <input type="text" name="id_kriteria" value="{{$krd->id}}" hidden>
                                    <label>Nama Sub-Kriteria: </label>
                                    <div class="mb-1">
                                        <input type="text" name="nama" placeholder="Nama Sub Kriteria" value="" class="form-control" />
                                    </div>

                                    <label>Nilai Sub-Kriteria: </label>
                                    <div class="mb-1">
                                        <input type="number" name="nilai" class="touchspin-min-max" value="1"/>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Accept</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- list section end -->
            </section>
            @foreach ($subdata as $sbd)
            {{-- modal Edit kriteria --}}
            <div class="modal fade text-start" id="modaleditsub{{$sbd->id}}" tabindex="-1" aria-labelledby="myModalLabel1"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel1">Edit Sub-Kriteria {{$sbd->nama}} | {{$krd->nama}} (C{{$krd->id}})</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="subkriteria/edit" method="post">
                            @csrf
                            <div class="modal-body">
                                <input type="text" name="idsub" value="{{$sbd->id}}" hidden>
                                <label>Nama Sub-Kriteria: </label>
                                <div class="mb-1">
                                    <input type="text" name="nama" placeholder="Nama Sub Kriteria" value="{{$sbd->nama}}" class="form-control" />
                                </div>
                                <label>Nilai Sub-Kriteria: </label>
                                <div class="mb-1">
                                    <input type="number" name="nilai" class="touchspin-min-max" value="{{$sbd->nilai}}"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Accept</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
            @endforeach


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
<!-- END: Content-->




@foreach ($subsdata as $skd)
<div class="modal fade text-start modal-danger" id="modaldel{{$skd->id}}" tabindex="-1" aria-labelledby="myModalLabel140"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel140">Konfirmasi Hapus Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apabila Kriteria dihapus, maka semua Sub-Kriteria dan Penilaian yang berhubungan dengan Kriteria tersebut akan terhapus, Yakin tetap menghapus?
            </div>
            <div class="modal-footer">
                <a href="subkriteria/destroy/{{$skd->id}}" class="btn btn-danger">Ya</a>
            </div>
        </div>
    </div>
</div>
@endforeach





@include('app.footer')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{asset('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
<script src="{{asset('app-assets/js/scripts/forms/form-number-input.min.js')}}"></script>
<script>
    $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $(document).ready( function () {
            $('.subTable').DataTable();
        } );
    </script>



{{-- MODAL SPACES --}}
