
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
              <h3 class="page-title">Jadwal Meeting</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Jadwal Meeting</li>
              </ul>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <!-- Confirm Join -->
        <div class="modal" id="joinConfirm" tabindex="-1" role="dialog" aria-labelledby="joinConfirm" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="{{ route('meeting.schedule.users_join') }}" method="POST">
              {!! csrf_field() !!}
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Untuk Bergabung</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="zoom_id" name="zoom_id">
                  <p>Apakah anda yakin ingin bergabung ke room meeting ?</p>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /Confirm Join -->

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
                        <th>Waktu Mulai</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                      <tr>
                        <td>{{ $v->name }}</td>
                        <td>{{ str_replace('-', '/', $v->start_date) }}</td>
                        <td>{{ $v->is_duration }} Menit</td>
                        <td>
                          @if ($v->is_start_meeting)
                            <span class="badge badge-pill bg-success-light">Aktif</span>
                          @else
                            <span class="badge badge-pill bg-danger-light">Tidak Aktif</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="#" class="btn btn-sm btn-white text-primary mr-2" onclick="joinConfirm('{{ $v->zoom_id }}')"><i class="fas fa-sign-in-alt mr-1"></i>Bergabung</a> 
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
    function joinConfirm(data) {
      $('#joinConfirm').modal('show')
      $('#zoom_id').val(data)
    }
  </script>
</html>