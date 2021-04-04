<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        <ul>
          <li class="menu-title"><span>Main</span></li>
          <li {{ request()->routeIs('dashboard.index') ? 'class=active' : '' }}><a href="/"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
          <li class="menu-title"><span>Modul Meeting</span></li>
          <li><a href="#"><i class="fa fa-calendar"></i> <span>Atur Jadwal</span></a></li>
          <li><a href="#"><i class="fa fa-user-plus"></i> <span>Undangan</span></a></li>
          <li><a href="#"><i class="fa fa-clock"></i> <span>Presensi</span></a></li>
          <li class="menu-title"><span>Pengaturan</span></li>
          <li><a href="#"><i class="fa fa-users"></i> <span>Master Pengguna</span></a></li>
          <li><a href="#"><i class="fa fa-envelope"></i> <span>Master SMTP</span></a></li>
          <li><a href="#"><i class="fa fa-video"></i> <span>Master Vidcon</span></a></li>
        </ul>
      </div>
   </div>
</div>

