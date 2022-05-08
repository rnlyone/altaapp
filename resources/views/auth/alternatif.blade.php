@include('app.app', ['alter_active' => 'active', 'title' => 'Data Alternatif'])

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
                            <h2 class="content-header-title float-start mb-0">Data Alternatif</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="alternatif">Data Alternatif</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard Analytics Start -->
            <section class="app-user-list">
                <!-- list section start -->
                <div class="card">
                    <div style="margin: 10pt">
                    <div class="card-datatable table-responsive pt-0">
                        <div class="card-header p-0">
                            <div class="head-label"><h5 class="mt-1">Tabel Data Alternatif</h5></div>
                            <div class="dt-action-buttons text-end">
                                <button data-toggle="modal" data-bs-toggle="modal" data-bs-target="#tambah-alternatif" href="javascript:void(0)" class="btn btn-success" id="tombol-tambah">
                                    <i data-feather='plus'></i>
                                </button>
                            </div>
                        </div>
                        <table class="user-list-table table" id="altertable">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Modal to add new user starts-->

                    </div>
                    <!-- Modal to add new user Ends-->
                </div>
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
@foreach ($alterdata as $ald)
<div class="modal fade text-start" id="modaledit{{$ald->id}}" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Edit Alternatif</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="alternatif/edit" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" name="idedit" value="{{$ald->id}}" hidden>
                    <label>Nama Alternatif: </label>
                    <div class="mb-1">
                        <input type="text" name="nama" placeholder="Nama Alternatif" value="{{$ald->nama}}" class="form-control" />
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

{{-- modal delete --}}
@foreach ($alterdata as $ald)
<div class="modal fade text-start modal-danger" id="modaldel{{$ald->id}}" tabindex="-1" aria-labelledby="myModalLabel140"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel140">Konfirmasi Hapus Alternatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apabila Dihapus, Semua Penilaian yang berkaitan dengan alternatif tersebut akan dihapus, tetap Hapus?
            </div>
            <div class="modal-footer">
                <a href="alternatif/destroy/{{$ald->id}}" class="btn btn-danger">Ya</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal to add new user starts-->
<div class="modal fade text-start" id="tambah-alternatif" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Tambah Alternatif</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="alternatif/store" method="post">
                @csrf
                <div class="modal-body">
                    <label>Id Alternatif: </label>
                    <div class="mb-1">
                        <input type="number" name="id" class="touchspin-min-max" value="{{$latestalter_id+1}}"/>
                    </div>

                    <label>Nama Alternatif: </label>
                    <div class="mb-1">
                        <input type="text" name="nama" placeholder="Nama Alternatif" value="" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- Modal to add new user Ends-->

{{-- MODAL END --}}


<!-- END: Content-->
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

    $(document).ready(function(){
        const table = $('#altertable').DataTable(
            {
                serverSide : true,
                processing : true,
                language : {
                    processing : "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>Loading...</span></div>"
                },

                ajax : {
                    url: '{{ route('alternatif.index') }}',
                    type: 'GET'
                },

                columns : [
                    {data: 'id'},
                    {data: 'nama'},
                    {data: 'action'}
                ],

                order: [[0, 'asc']],
                "drawCallback" : function( settings ) {
                    feather.replace();
                }
            })
        });
</script>
