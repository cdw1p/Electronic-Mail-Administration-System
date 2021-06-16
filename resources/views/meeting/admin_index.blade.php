
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
              <h3 class="page-title">Presensi Meeting</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Meeting</a>
                </li>
                <li class="breadcrumb-item active">Presensi Meeting</li>
              </ul>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <!-- List Participant -->
        <div class="modal" id="listParticipant" tabindex="-1" role="dialog" aria-labelledby="listParticipant" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form>
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Daftar Partisipan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"><table class="table table-condensed">
                  <table class="table table-center table-hover">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody id="dataListParticipants"></tbody>
                  </table>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /List Participant -->

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
                        <th>Peserta Hadir</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                      <tr>
                        <td>{{ $v->name }}</td>
                        <td>{{ str_replace('-', '/', $v->start_date) }}</td>
                        <td>{{ $v->total_participants }} Peserta</td>
                        <td class="text-center">
                          <a href="#" class="btn btn-sm btn-white text-primary mr-2" onclick="fetchParticipantsList('{{ $v->zoom_id }}')"><i class="far fa-eye mr-1"></i>Lihat Peserta</a> 
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
    function fetchParticipantsList(data) {
      fetch(`/meeting/attendance/getParticipants/${data}`)
        .then(response => response.json())
        .then(data => {
          $('#dataListParticipants').empty()
          $('#listParticipant').modal('show')
          for (dataList of data) {
            $('#dataListParticipants').append(`<tr><td>${dataList.name}</td><td>${dataList.email}</td></tr>`)
          }
        })
    }
  </script>
</html>