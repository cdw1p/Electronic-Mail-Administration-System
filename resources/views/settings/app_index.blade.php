
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
              <h3 class="page-title">Master Aplikasi</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Pengaturan</a>
                </li>
                <li class="breadcrumb-item active">Master Aplikasi</li>
              </ul>
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
                  <div class="col-md-12">
                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @endif
                    @if ($message = Session::get('success'))
                      <div class="alert alert-success" role="alert">{{ $message }}</div>
                    @endif
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12">
												<div class="form-group">
                          <label>SMTP Host</label>
                          <input type="text" class="form-control" id="smtp_host" name="smtp_host"  value="{{ $data->smtp_host }}" required />
												</div>
											</div>
                      <div class="col-md-12">
												<div class="form-group">
                          <label>SMTP Port</label>
                          <input type="text" class="form-control" id="smtp_port" name="smtp_port"  value="{{ $data->smtp_port }}" required />
												</div>
											</div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>SMTP Username</label>
                          <input type="text" class="form-control" id="smtp_username" name="smtp_username"  value="{{ $data->smtp_username }}" required />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>SMTP Password</label>
                          <input type="password" class="form-control" id="smtp_password" name="smtp_password"  value="{{ $data->smtp_password }}" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Zoom Client Key</label>
                          <input type="text" class="form-control" id="zoom_key" name="zoom_key" value="{{ $data->zoom_key }}" required />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Zoom Secret Key</label>
                          <input type="text" class="form-control" id="zoom_secret" name="zoom_secret" value="{{ $data->zoom_secret }}" required />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Terakhir Diupdate</label>
                          <input type="text" class="form-control" value="{{ $data->updated_at }}" readonly />
                        </div>
                      </div>
                      <div class="col-md-12 mt-4">
                        <div class="text-right">
                          <button type="submit" class="btn btn-primary">Simpan Data</button>
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