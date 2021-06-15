<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        <ul>
          <li class="menu-title"><span>Main</span></li>
          <li {{ (request()->routeIs('dashboard.index') || request()->routeIs('profile.index')) ? 'class=active' : '' }}>
            <a href="{{ route('dashboard.index') }}"><i class="fa fa-home"></i> <span>Dashboard</span></a>
          </li>

          @if (Auth::user()->role === 'user')
            <li {{ (request()->routeIs('meeting.schedule.users_index')) ? 'class=active' : '' }}>
              <a href="{{ route('meeting.schedule.users_index') }}"><i class="fa fa-calendar"></i> <span>Jadwal Meeting</span></a>
            </li>
            <li {{ (request()->routeIs('meeting.schedule.users_attendance')) ? 'class=active' : '' }}>
              <a href="{{ route('meeting.schedule.users_attendance') }}"><i class="fa fa-clock"></i> <span>Riwayat Presensi</span></a>
            </li>
          @endif

          @if (Auth::user()->role === 'admin')
            <li class="menu-title"><span>Modul Meeting</span></li>
            <li {{ (request()->routeIs('meeting.schedule.index') || request()->routeIs('meeting.schedule.create') || request()->routeIs('meeting.schedule.edit')) ? 'class=active' : '' }}>
              <a href="{{ route('meeting.schedule.index') }}"><i class="fa fa-calendar"></i> <span>Atur Jadwal</span></a>
            </li>
            <li {{ (request()->routeIs('meeting.invitation.index') || request()->routeIs('meeting.invitation.create') || request()->routeIs('meeting.invitation.edit')) ? 'class=active' : '' }}>
              <a href="{{ route('meeting.invitation.index') }}"><i class="fa fa-user-plus"></i> <span>Undangan</span></a>
            </li>
            <li><a href="#"><i class="fa fa-clock"></i> <span>Presensi</span></a></li>

            <li class="menu-title"><span>Pengaturan</span></li>
            <li {{ (request()->routeIs('settings.users.index') || request()->routeIs('settings.users.create') || request()->routeIs('settings.users.edit')) ? 'class=active' : '' }}>
              <a href="{{ route('settings.users.index') }}"><i class="fa fa-users"></i> <span>Master Pengguna</span></a>
            </li>
            <li {{ request()->routeIs('settings.app.index') ? 'class=active' : '' }}>
              <a href="{{ route('settings.app.index') }}"><i class="fa fa-cog"></i> <span>Master Aplikasi</span></a>
            </li>
          @endif
        </ul>
      </div>
   </div>
</div>

