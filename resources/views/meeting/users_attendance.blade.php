
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
              <h3 class="page-title">Riwayat Absensi</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Riwayat Absensi</li>
              </ul>
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
                        <th>Nama Room Meeting</th>
                        <th>Tanggal Absensi</th>
                        <th class="text-center">Unduhan</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                      <tr>
                        <td>{{ $v->name }}</td>
                        <td><span class="badge badge-pill bg-success-light">{{ $v->created_at }}</span></td>
                        <td class="text-center">
                          <a href="#" class="btn btn-sm btn-white text-primary mr-2" onclick="joinConfirm('{{ $v->zoom_id }}')"><i class="fa fa-file-pdf mr-1"></i>Sertifikat Kehadiran</a> 
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