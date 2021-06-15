
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
                          <a href="{{ route('meeting.schedule.delete', $v->zoom_id) }}" class="btn btn-sm btn-white text-danger mr-2"><i class="far fa-trash-alt mr-1"></i>Hapus</a>
                          <a href="{{ route('meeting.schedule.stop', $v->zoom_id) }}" class="btn btn-sm btn-white text-danger mr-2"><i class="fa fa-stop mr-1"></i>Stop</a>
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
</html>