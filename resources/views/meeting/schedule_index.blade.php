
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
              <h3 class="page-title">Atur Jadwal</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Meeting</a>
                </li>
                <li class="breadcrumb-item active">Atur Jadwal</li>
              </ul>
            </div>
            <div class="col-auto">
              <a href="{{ route('meeting.schedule.create') }}" class="btn btn-primary mr-1">
                <i class="fas fa-plus"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <!-- Confirm Delete -->
        <div class="modal" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="{{ route('meeting.schedule.delete') }}" method="POST">
              {!! csrf_field() !!}
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Untuk Menghapus</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input class="zoom_id_delete" type="hidden" id="zoom_id" name="zoom_id">
                  <p>Apakah anda yakin ingin menghapus jadwal meeting ?</p>
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

        <!-- Confirm Stop -->
        <div class="modal" id="stopConfirm" tabindex="-1" role="dialog" aria-labelledby="stopConfirm" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="{{ route('meeting.schedule.stop') }}" method="POST">
              {!! csrf_field() !!}
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Untuk Memberhentikan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input class="zoom_id_stop" type="hidden" id="zoom_id" name="zoom_id">
                  <p>Apakah anda yakin ingin memberhentikan jadwal meeting ?</p>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /Confirm Stop -->

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
                        <th>Rekaman</th>
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
                          @if ($v->is_recording)
                            <span class="badge badge-pill bg-success-light">Aktif</span>
                          @else
                            <span class="badge badge-pill bg-danger-light">Tidak Aktif</span>
                          @endif
                        </td>
                        <td>
                          @if ($v->is_start_meeting)
                            <span class="badge badge-pill bg-success-light">Aktif</span>
                          @else
                            <span class="badge badge-pill bg-danger-light">Tidak Aktif</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="{{ route('meeting.schedule.edit', $v->zoom_id) }}" class="btn btn-sm btn-white text-success mr-2"><i class="far fa-edit mr-1"></i>Ubah</a> 
                          <a href="#" class="btn btn-sm btn-white text-danger mr-2" onclick="deleteConfirm('{{ $v->zoom_id }}')"><i class="far fa-trash-alt mr-1"></i>Hapus</a>
                          <a href="#" class="btn btn-sm btn-white text-danger mr-2" onclick="stopConfirm('{{ $v->zoom_id }}')"><i class="fa fa-stop mr-1"></i>Stop</a>
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
      $('.zoom_id_delete').val(data)
    }
    function stopConfirm(data) {
      $('#stopConfirm').modal('show')
      $('.zoom_id_stop').val(data)
    }
  </script>
</html>