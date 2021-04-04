
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
    <div id="app" class="page-wrapper">
      <div class="content container-fluid">
        <div class="row">
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-1">
                    <i class="fas fa-video"></i>
                  </span>
                  <div class="dash-count">
                    <div class="dash-title">Total Vidcon</div>
                    <div class="dash-counts">
                      <p>0</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-2">
                    <i class="fa fa-users"></i>
                  </span> 
                  <div class="dash-count">
                    <div class="dash-title">Total Pengguna</div>
                    <div class="dash-counts">
                      <p>0</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-3">
                    <i class="fas fa-sign-in-alt"></i>
                  </span>
                  <div class="dash-count">
                    <div class="dash-title">Total Presensi</div>
                    <div class="dash-counts">
                      <p>0</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-4">
                    <i class="fas fa-envelope"></i>
                  </span>
                  <div class="dash-count">
                    <div class="dash-title">Total SMTP</div>
                    <div class="dash-counts">
                      <p>0</p>
                    </div>
                  </div>
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
  @extends('layouts.footer')
</html>