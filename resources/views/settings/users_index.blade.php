
<!DOCTYPE html>
<html lang="en">
@extends('layouts.header')
<body>
  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <!-- Header -->
    @extends('layouts.topbar')
    <!-- /Header -->

    <!-- Sidebar -->
    @extends('layouts.sidebar')
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
      <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="page-title">Master Pengguna</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Pengaturan</a>
                </li>
                <li class="breadcrumb-item active">Master Pengguna</li>
              </ul>
            </div>
            <div class="col-auto">
              <a href="{{ route('settings.users.create') }}" class="btn btn-primary mr-1">
                <i class="fas fa-plus"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <!-- Confirm Delete -->
        <div class="modal" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="{{ route('settings.users.delete') }}" method="POST">
              {!! csrf_field() !!}
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Untuk Menghapus</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input class="email_delete" type="hidden" id="email" name="email">
                  <p>Apakah anda yakin ingin menghapus akun ini ?</p>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /Confirm Delete -->

        <div class="row">
          <div class="col-md-12">
            @if ($message = Session::get('error'))
              <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @endif
            @if ($message = Session::get('success'))
              <div class="alert alert-success" role="alert">{{ $message }}</div>
            @endif
          </div>
          <div class="col-sm-12">
            <div class="card card-table">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-center table-hover datatable">
                    <thead class="thead-light">
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                      <tr>
                        <td>{{ $v->name }}</td>
                        <td>{{ $v->email }}</td>
                        <td>{{ strtoupper($v->role) }}</td>
                        <td>
                          @if ($v->status)
                            <span class="badge badge-pill bg-success-light">Aktif</span>
                          @else
                            <span class="badge badge-pill bg-danger-light">Tidak Aktif</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="{{ route('settings.users.edit', $v->email) }}" class="btn btn-sm btn-white text-success mr-2"><i class="far fa-edit mr-1"></i>Ubah</a> 
                          <a href="#" class="btn btn-sm btn-white text-danger mr-2" onclick="deleteConfirm('{{ $v->email }}')"><i class="far fa-trash-alt mr-1"></i>Hapus</a>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Page Wrapper -->
  </div>
  <!-- /Main Wrapper -->
  <!-- Datatables JS -->
  @extends('layouts.footer')
  <script>
    function deleteConfirm(data) {
      $('#deleteConfirm').modal('show')
      $('.email_delete').val(data)
    }
  </script>
</html>