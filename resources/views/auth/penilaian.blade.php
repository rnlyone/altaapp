@include('app.app', ['penilaian_active' => 'active', 'title' => 'Penilaian'])

@php
    use App\Models\Subkriteria;
    use App\Models\Penilaian;
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
                            <h2 class="content-header-title float-start mb-0">Penilaian</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="alternatif">Penilaian</a>
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
                            <div class="head-label"><h5 class="mt-1">Tabel Penilaian</h5></div>
                            <div class="dt-action-buttons text-end">
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
                <h4 class="modal-title" id="myModalLabel1">Edit Penilaian {{$ald->nama}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="penilaian/edit" method="post">
                @csrf
                <input type="text" name="alternatifid" id="aldata" value="{{$ald->id}}" hidden>
                <div class="modal-body">
                    @foreach ($kritdata as $krd)
                        <label>{{$krd->nama}} : </label>
                        <div class="mb-1">
                            @php
                                $subdata = Subkriteria::where('id_kriteria', $krd->id)->orderBy('nilai', 'asc')->get();
                                try {
                                    $nilaidata = Penilaian::where('id_user', auth()->user()->id)
                                                ->where('id_alternatif', $ald->id)
                                                ->where('id_kriteria', $krd->id)
                                                ->first()->id_subkriteria;
                                } catch (\Throwable $th) {
                                    $nilaidata = null;
                                }
                            @endphp
                            <select name="{{$krd->id}}" class="form-select" id="basicSelect">
                                <option value=""
                              @if ($nilaidata == null)
                                selected="selected"
                              @endif>pilih nilai</option>
                              @foreach ($subdata as $sbd)
                              <option value="{{$sbd->id}}"
                                @if ($sbd->id == $nilaidata)
                                    selected="selected"
                                @endif
                                >{{$sbd->nilai}} | {{$sbd->nama}}</option>
                              @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
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
                    url: '{{ route('penilaian.index') }}',
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
