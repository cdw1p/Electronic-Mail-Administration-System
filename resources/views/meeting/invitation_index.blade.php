
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
              <h3 class="page-title">Undangan</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Meeting</a>
                </li>
                <li class="breadcrumb-item active">Undangan</li>
              </ul>
            </div>
            <div class="col-auto">
              <a href="#" class="btn btn-primary mr-1" data-toggle="modal" data-target="#addParticipant">
                <i class="fas fa-plus"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <!-- Add Participant -->
        <div class="modal" id="addParticipant" tabindex="-1" role="dialog" aria-labelledby="addParticipant" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('meeting.invitation.store') }}">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Partisipan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  {{ csrf_field() }}
                  <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Pilih Room Meeting</label>
                          <select class="form-control" name="room_id" onchange="fetchParticipantsData(this)" required />
                            <option selected disabled>-- Silahkan Pilih Room --</option>
                            @foreach($dataRoom as $dataR)
                              <option value="{{ $dataR->zoom_id }}">{{ $dataR->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Tambahkan Pengguna</label>
                          <select style="width: 100%;" class="select-room-users form-control" id="participants" name="participants[]" multiple="multiple" required />
                            @foreach($dataUser as $dataU)
                              <option value="{{ $dataU->user_telegram }}|{{ $dataU->email }}|{{ $dataU->name }}">{{ $dataU->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- /Add Participant -->

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

        <!-- Confirm Delete -->
        <div class="modal" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirm" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="{{ route('meeting.invitation.delete') }}" method="POST">
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
                  <p>Apakah anda yakin ingin menghapus undangan meeting ?</p>
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
                        <th>Nama Meeting</th>
                        <th>Waktu Mulai</th>
                        <th>Jumlah Peserta</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $v)
                      <tr>
                        <td>{{ $v->name }}</td>
                        <td>{{ str_replace('-', '/', $v->start_date) }}</td>
                        <td>{{ $v->total_participants }} Peserta</td>
                        <td>
                          @if ($v->is_start_meeting)
                            <span class="badge badge-pill bg-success-light">Aktif</span>
                          @else
                            <span class="badge badge-pill bg-danger-light">Tidak Aktif</span>
                          @endif
                        </td>
                        <td class="text-center">
                          <a href="#" class="btn btn-sm btn-white text-primary mr-2" onclick="fetchParticipantsList('{{ $v->zoom_id }}')"><i class="far fa-eye mr-1"></i>Lihat Peserta</a> 
                          <a href="#" class="btn btn-sm btn-white text-danger mr-2" onclick="deleteConfirm('{{ $v->zoom_id }}')"><i class="far fa-trash-alt mr-1"></i>Hapus</a>
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
    let dataUsers = @json($dataUser, JSON_PRETTY_PRINT);
    function fetchParticipantsData(data) {
      fetch(`/meeting/invitation/getParticipants/${data.value}`)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            $('#participants').empty()
            for (users of dataUsers) {
              const { user_telegram, email, name } = users
              const formatEmailName = `${user_telegram}|${email}|${name}`
              if (JSON.parse(data[0].participants).filter(data => data.split('|')[1] === email).length > 0) {
                $('#participants').append($(`<option value="${formatEmailName}" selected>${name}</option>`))
              } else {
                $('#participants').append($(`<option value="${formatEmailName}">${name}</option>`))
              }
            }
          }
        })
    }
    function fetchParticipantsList(data) {
      fetch(`/meeting/invitation/getParticipants/${data}`)
        .then(response => response.json())
        .then(data => {
          $('#dataListParticipants').empty()
          $('#listParticipant').modal('show')
          for (dataList of JSON.parse(data[0].participants)) {
            $('#dataListParticipants').append(`<tr><td>${dataList.split('|')[1]}</td><td>${dataList.split('|')[0]}</td></tr>`)
          }
        })
    }
    function deleteConfirm(data) {
      $('#deleteConfirm').modal('show')
      $('.zoom_id_delete').val(data)
    }
  </script>
</html>