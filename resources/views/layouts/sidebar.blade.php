<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        <ul>
          <li class="menu-title"><span>Main</span></li>
          <li {{ request()->routeIs('dashboard.index') ? 'class=active' : '' }}><a href="{{ route('dashboard.index') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

          @if (Auth::user()->role === 'admin')
            <li class="menu-title"><span>Modul Meeting</span></li>
            <li {{ request()->routeIs('meeting.schedule.index') ? 'class=active' : '' }}><a href="{{ route('meeting.schedule.index') }}"><i class="fa fa-calendar"></i> <span>Atur Jadwal</span></a></li>
            <li><a href="{{ route('meeting.invitation.index') }}"><i class="fa fa-user-plus"></i> <span>Undangan</span></a></li>
            <li><a href="#"><i class="fa fa-clock"></i> <span>Presensi</span></a></li>

            <li class="menu-title"><span>Pengaturan</span></li>
            <li {{ request()->routeIs('settings.users.index') ? 'class=active' : '' }}><a href="{{ route('settings.users.index') }}"><i class="fa fa-users"></i> <span>Master Pengguna</span></a></li>
            <li {{ request()->routeIs('settings.app.index') ? 'class=active' : '' }}><a href="{{ route('settings.app.index') }}"><i class="fa fa-cog"></i> <span>Master Aplikasi</span></a></li>
          @endif
        </ul>
      </div>
   </div>
</div>

