@include('app.app', ['user_active' => 'active', 'title' => 'User Management'])

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
                            <h2 class="content-header-title float-start mb-0">User Management</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="alternatif">User Management</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @error('email')
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <div class="alert-body">
                        {{$message}}
                    </div>
                </div>
            @enderror
            @error('password')
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <div class="alert-body">
                        {{$message}}
                    </div>
                </div>
            @enderror
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
            <!-- Dashboard Analytics Start -->
            <section class="app-user-list">
                <!-- list section start -->
                <div class="card">
                    <div style="margin: 10pt">
                    <div class="card-datatable table-responsive pt-0">
                        <div class="card-header p-0">
                            <div class="head-label"><h5 class="mt-1">Tabel User</h5></div>
                            <div class="dt-action-buttons text-end">
                                <button data-toggle="modal" data-bs-toggle="modal" data-bs-target="#tambah-user" href="javascript:void(0)" class="btn btn-success" id="tombol-tambah">
                                    <i data-feather='plus'></i>
                                </button>
                            </div>
                        </div>
                        <table class="user-list-table table" id="usertable">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    </div>
                </div>
                <!-- list section end -->
            </section>


        </div>
    </div>
</div>

{{-- MODAL --}}
@foreach ($userdata as $usd)
<div class="modal fade text-start" id="modaledit{{$usd->id}}" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Edit User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="user/edit" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" name="idedit" placeholder="Id Alternatif" value="{{$usd->id}}" class="form-control" hidden>
                    <label>Id User: </label>
                    <div class="mb-1">
                        <input type="number" name="id" class="touchspin-min-max" value="{{$usd->id}}"/>
                    </div>

                    <label>Nama User: </label>
                    <div class="mb-1">
                        <input type="text" name="name" placeholder="Nama User" value="{{$usd->name}}" class="form-control" />
                    </div>

                    <label>Email User: </label>
                    <div class="mb-1">
                        <input type="email" name="email" placeholder="Email User" value="{{$usd->email}}" class="form-control" />
                    </div>

                    <label>Password User: </label>
                    <div class="mb-1">
                        <input type="password" name="password" placeholder="Password User" value="" class="form-control"/>
                    </div>

                    <label>Role User: </label>
                    <div class="mb-1">
                        <div class="demo-inline-spacing">
                            <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="adminid"
                                  value="admin"
                                  @if ($usd->role == "admin")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="adminid">Admin</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="kepsekid"
                                  value="kepsek"
                                  @if ($usd->role == "kepsek")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="kepsekid">Kepala Sekolah</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="idguru"
                                  value="guru"
                                  @if ($usd->role == "guru")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="idguru">Guru</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="idmhs"
                                  value="mhs"
                                  @if ($usd->role == "mhs")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="idmhs">Mahasiswa Kampus Mengajar</label>
                              </div>
                        </div>
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
@foreach ($userdata as $usd)
<div class="modal fade text-start modal-danger" id="modaldel{{$usd->id}}" tabindex="-1" aria-labelledby="myModalLabel140"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel140">Konfirmasi Hapus User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apabila Dihapus, Semua Penilaian yang berkaitan dengan User tersebut akan dihapus, tetap Hapus?
            </div>
            <div class="modal-footer">
            <a href="user/destroy/{{$usd->id}}" class="btn btn-danger">Ya</a>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal to add new user starts-->
<div class="modal fade text-start" id="tambah-user" tabindex="-1" aria-labelledby="myModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">Tambah User</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="user/store" method="post">
                @csrf
                <div class="modal-body">
                    <label>Id User: </label>
                    <div class="mb-1">
                        <input type="number" name="id" class="touchspin-min-max" value="{{$latestuser_id+1}}"/>
                    </div>

                    <label>Nama User: </label>
                    <div class="mb-1">
                        <input type="text" name="name" placeholder="Nama User" value="" class="form-control" />
                    </div>

                    <label>Email User: </label>
                    <div class="mb-1">
                        <input type="email" name="email" placeholder="Email User" value="" class="form-control" />
                    </div>

                    <label>Password User: </label>
                    <div class="mb-1">
                        <input type="password" name="password" placeholder="Password User" value="" class="form-control" minlength="8"/>
                    </div>

                    <label>Role User: </label>
                    <div class="mb-1">
                        <div class="demo-inline-spacing">
                            <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="adminid"
                                  value="admin"
                                  @if ($usd->role == "admin")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="adminid">Admin</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="kepsekid"
                                  value="kepsek"
                                  @if ($usd->role == "kepsek")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="kepsekid">Kepala Sekolah</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="idguru"
                                  value="guru"
                                  @if ($usd->role == "guru")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="idguru">Guru</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input
                                  class="form-check-input"
                                  type="radio"
                                  name="role"
                                  id="idmhs"
                                  value="mhs"
                                  @if ($usd->role == "mhs")
                                    checked
                                  @endif
                                />
                                <label class="form-check-label" for="idmhs">Mahasiswa Kampus Mengajar</label>
                              </div>
                        </div>
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
        const table = $('#usertable').DataTable(
            {
                serverSide : true,
                processing : true,
                language : {
                    processing : "<div class='spinner-border text-primary' role='status'> <span class='visually-hidden'>Loading...</span></div>"
                },

                ajax : {
                    url: '{{ route('user.index') }}',
                    type: 'GET'
                },

                columns : [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'role'},
                    {data: 'action'}
                ],

                order: [[0, 'asc']],
                "drawCallback" : function( settings ) {
                    feather.replace();
                }
            })
        });
</script>
