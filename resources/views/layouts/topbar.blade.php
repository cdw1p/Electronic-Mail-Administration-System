<div class="header">
  <!-- Logo -->
  <div class="header-left">
    <a href="{{ route('dashboard.index') }}" class="logo">
      <img src="/assets/img/logo.png" alt="Logo">
    </a>
    <a href="{{ route('dashboard.index') }}" class="logo logo-small">
      <img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30">
    </a>
  </div>
  <!-- /Logo -->
  <!-- Sidebar Toggle -->
  <a href="javascript:void(0);" id="toggle_btn">
    <i class="fas fa-bars"></i>
  </a>
  <!-- /Sidebar Toggle -->

  <!-- Mobile Menu Toggle -->
  <a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
  </a>
  <!-- /Mobile Menu Toggle -->

  <!-- Header Menu -->
  <ul class="nav user-menu">
    <!-- User Menu -->
    <li class="nav-item dropdown has-arrow main-drop">
      <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
        <span class="user-img">
          <img src="/assets/img/profiles/user.svg" alt="">
          <span class="status online"></span>
        </span>
        &nbsp;
        <span>{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</span>
      </a>
      &nbsp;
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('profile.index') }}"><i class="mr-1"></i> Ubah Profile</a>
        <a class="dropdown-item" href="{{ route('dashboard.logout') }}"><i class="mr-1"></i> Keluar</a>
      </div>
    </li>
    <!-- /User Menu -->
  </ul>
  <!-- /Header Menu -->
</div>