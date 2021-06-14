
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
              <h3 class="page-title">Tambah Jadwal</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Meeting</a>
                </li>
                <li class="breadcrumb-item active">Tambah Jadwal</li>
              </ul>
            </div>
            <div class="col-auto">
              <a class="btn btn-primary filter-btn" href="{{ route('meeting.schedule.index') }}">
                <i class="fas fa-arrow-left"></i>
              </a>
            </div>
          </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form method="POST">
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nama Meeting</label>
                          <input type="text" class="form-control" id="name" name="name" required />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Waktu Dimulai</label>
                          <input type="datetime-local" class="form-control" id="start_date" name="start_date" required />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Durasi Zoom</label>
													<select class="form-control" id="is_duration" name="is_duration">
														<option value="60">60 Menit</option>
														<option value="45">45 Menit</option>
														<option value="30">30 Menit</option>
														<option value="20">20 Menit</option>
														<option value="10">10 Menit</option>
														<option value="5">5 Menit</option>
													</select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="col-md-12">
												<div class="form-group">
													<label>Status Meeting</label>
													<select class="form-control" id="is_start_meeting" name="is_start_meeting">
														<option value="1">Aktif</option>
														<option value="0">Tidak Aktif</option>
													</select>
												</div>
											</div>
                      <div class="col-md-12">
												<div class="form-group">
													<label>Status Rekaman</label>
													<select class="form-control" id="is_recording" name="is_recording">
														<option value="1">Aktif</option>
														<option value="0">Tidak Aktif</option>
													</select>
												</div>
											</div>
                      <div class="col-md-12 mt-4">
												<div class="form-group">
                          <div class="text-right">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
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