<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Invitation;
use App\Models\Attendance;
use Session;
use QrCode;
use PDF;

class MeetingScheduleController extends Controller
{
  public function admin_attendance(Request $request) {
    $query = Attendance::select(Attendance::raw('count(attendances.id_rooms) as total_participants, rooms.name, rooms.start_date, rooms.zoom_id'))
            ->join('rooms', 'attendances.id_rooms', '=', 'rooms.zoom_id')
            ->get();
    if ($query[0]->total_participants === 0) {
      return view('meeting/admin_index', ['data' => []]);
    } else {
      return view('meeting/admin_index', ['data' => $query]);
    }
  }

  public function users_index(Request $request) {
    $query = Invitation::join('rooms', 'invitations.room_id', '=', 'rooms.zoom_id')
            ->where('invitations.participants', 'like', '%' . Auth::user()->email . '%')
            ->get();
    return view('meeting/users_index', ['data' => $query]);
  }

  public function users_attendance(Request $request) {
    $query = Room::select('rooms.name', 'attendances.signature', 'attendances.created_at')
            ->join('attendances', 'rooms.zoom_id', '=', 'attendances.id_rooms')
            ->where('attendances.email', '=', Auth::user()->email)
            ->get();
    return view('meeting/users_attendance', ['data' => $query]);
  }

  public function users_join(Request $request) {
    $query = Invitation::join('rooms', 'invitations.room_id', '=', 'rooms.zoom_id')
            ->where('participants', 'like', '%' . Auth::user()->email . '%')
            ->where('rooms.is_start_meeting', '=', '1')
            ->get();
    if (count($query) > 0) {
      $findAttendance = Attendance::where('id_rooms', $request->zoom_id)->where('email', Auth::user()->email)->get();
      if (count($findAttendance) < 1) {
        $email = Auth::user()->email;
        Mail::raw('Anda telah berhasil menghadiri meeting dengan zoom id "'. $request->zoom_id .'".', function($msg) use ($email) {
          $msg->subject('Notifikasi Kehadiran Meeting!')->to($email);
        });
        Attendance::create([ 'id_rooms' => $request->zoom_id, 'email' => Auth::user()->email, 'signature' => Crypt::encrypt($query) ]);
      }
      return redirect($query[0]->zoom_link);
    } else {
      Session::flash('error', 'Maaf, status room meeting yang anda tuju sedang tidak aktif. Silahkan hubungi administrator!');
      return redirect()->route('meeting.schedule.users_index');
    }
  }

  public function users_verify(Request $request) {
    try {
      $decryptParams = Crypt::decrypt($request->signature);
      if ($decryptParams) {
        $qrCodeGenerator = base64_encode(QrCode::format('svg')->size(100)->generate(Auth::user()->name));
        $templateHTML = '
          <h1>Contoh Sertifikat Kehadiran</h1><br/>
          <h3>Dihadiri Oleh : '. Auth::user()->name .'</h3>
          <h3>Nama Room Meeting : '. $decryptParams[0]->name .'</h3>
          <img src="data:image/png;base64, '. $qrCodeGenerator .'">
        ';
        return PDF::loadHTML($templateHTML)->setPaper('a4', 'landscape')->setWarnings(false)->stream();
      } else {
        return redirect()->route('meeting.schedule.users_attendance');
      }
    } catch (DecryptException $e) {
      return redirect()->route('meeting.schedule.users_attendance');
    }
  }

  public function index(Request $request) {
    return view('meeting/schedule_index', ['data' => Room::all()]);
  }

  public function create(Request $request) {
    return view('meeting/schedule_create');
  }

  public function edit(Request $request) {
    $findData = Room::where('zoom_id', $request->id)->first();
    if ($findData) {
      return view('meeting/schedule_edit', ['data' => $findData]);
    } else {
      return redirect()->route('meeting.schedule.index');
    }
  }

  public function store(Request $request) {
    $findDatabase = Room::where('name', $request->name)->first();
    $findZoomData = Zoom::user()->first()->meetings()->all();
    $matchZoomData = collect([]);
    foreach ($findZoomData as $data) {
      if ($data->topic === $request->name) {
        $matchZoomData = $data;
      }
    }
    if (!$findDatabase && count($matchZoomData) < 1) {
      $meeting = Zoom::meeting()->make([ 'topic' => $request->name, 'type' => 8, 'start_time' => new Carbon($request->start_date), 'duration' => $request->is_duration, 'timezone' => 'Asia/Jakarta' ]);
      $meeting->recurrence()->make([ 'type' => 3, 'repeat_interval' => '0', 'weekly_days' => '0', 'end_times' => '0' ]);
      $meeting->settings()->make([ 'join_before_host' => false, 'approval_type' => 0, 'registration_type' => 2, 'enforce_login' => false, 'auto_recording' => $request->is_recording ? 'cloud' : 'local' ]);
      $createMeeting = Zoom::user()->first()->meetings()->save($meeting);
      $findLastestZoomData = Zoom::user()->first()->meetings()->all();
      $zoomData = collect([]);
      foreach ($findLastestZoomData as $data) {
        if ($data->topic === $request->name) {
          $zoomData = $data;
        }
      }
      $createRoom = Room::create([
        'name'                => $request->name,
        'start_date'          => new Carbon($request->start_date),
        'is_duration'         => $request->is_duration,
        'is_recording'        => $request->is_recording,
        'is_start_meeting'    => $request->is_start_meeting,
        'is_join_before_host' => false,
        'zoom_id'             => $zoomData->id,
        'zoom_link'           => $zoomData->join_url
      ]);
      if ($createMeeting && $createRoom) {
        Session::flash('success', 'Selamat, data meeting berhasil disimpan kedalam database server!');
      } else {
        Session::flash('error', 'Maaf, data meeting tidak dapat disimpan. Silahkan coba lagi!');
      }
    } else {
      Session::flash('error', 'Maaf, data meeting tersedia pada database server. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.schedule.index');
  }

  public function update(Request $request) {
    $findData = Zoom::user()->first()->meetings()->find($request->id);
    if ($findData) {
      if (!($request->is_start_meeting)) {
        Zoom::user()->first()->meetings()->find($request->id)->endMeeting();
      }
      Zoom::user()->first()->meetings()->find($request->id)->update([ 'topic' => $request->name ]);
      Room::where('zoom_id', $request->id)->update($request->except(['_token']));
      Session::flash('success', 'Selamat, data meeting berhasil diubah pada database server!');
    } else {
      Session::flash('error', 'Maaf, data meeting tidak dapat diubah. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.schedule.index');
  }

  public function stop(Request $request) {
    $findData = Zoom::user()->first()->meetings()->find($request->zoom_id);
    if ($findData) {
      Zoom::user()->first()->meetings()->find($request->zoom_id)->endMeeting();
      Room::where('zoom_id', $request->zoom_id)->update([ 'is_start_meeting' => 0 ]);
      Session::flash('success', 'Selamat, data meeting berhasil diberhentikan pada server!');
    } else {
      Session::flash('error', 'Maaf, data meeting tidak dapat diberhentikan. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.schedule.index');
  }

  public function delete(Request $request) {
    $findData = Zoom::user()->first()->meetings()->find($request->zoom_id);
    if ($findData) {
      Zoom::user()->first()->meetings()->find($request->zoom_id)->delete();
      Room::where('zoom_id', $request->zoom_id)->delete();
      Session::flash('success', 'Selamat, data meeting berhasil dihapus pada database server!');
    } else {
      Session::flash('error', 'Maaf, data meeting tidak dapat dihapus. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.schedule.index');
  }

  public function getParticipants(Request $request) {
    return Attendance::select('attendances.email', 'users.name', 'users.user_telegram')
          ->join('users', 'attendances.email', '=', 'users.email')
          ->where('id_rooms', $request->id)
          ->get();
  }
}