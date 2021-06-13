
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
              <h3 class="page-title">Ubah Profile</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Ubah Profile</li>
              </ul>
            </div>
            <div class="col-auto">
              <a class="btn btn-primary filter-btn" href="/">
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
                <form action="/profile/update" method="POST">
                  {!! csrf_field() !!}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Nama Lengkap</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" required />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Alamat Email</label>
                          <input type="text" class="form-control" id="email" name="email" value="{{ $data->email }}" required />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Ganti Kata Sandi</label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="(Opsional)">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Tanggal Registrasi</label>
                          <input type="text" class="form-control" value="{{ $data->created_at }}" readonly />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="text-right">
                      <button type="submit" class="btn btn-primary">Simpan Data</button>
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