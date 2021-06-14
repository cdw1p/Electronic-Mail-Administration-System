<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
use App\Models\Room;
use Session;

class MeetingScheduleController extends Controller
{
  public function index(Request $request) {
    return view('meeting/room_index', ['data' => Room::all()]);
  }

  public function create(Request $request) {
    return view('meeting/room_create');
  }

  public function edit(Request $request) {
    $findData = Room::where('zoom_id', $request->id)->first();
    if ($findData) {
      return view('meeting/room_edit', ['data' => $findData]);
    } else {
      return redirect()->route('meeting.schedule.index');
    }
  }

  public function store(Request $request) {
    $findDatabase = Room::where('name', $request->name)->first();
    $findZoomData = Zoom::user()->first()->meetings()->where('topic', $request->name)->get();
    if (!$findDatabase && count($findZoomData) < 1) {
      $meeting = Zoom::meeting()->make([ 'topic' => $request->name, 'type' => 8, 'start_time' => new Carbon($request->start_date), 'duration' => $request->is_duration, 'timezone' => 'Asia/Jakarta' ]);
      $meeting->recurrence()->make([ 'type' => 3, 'repeat_interval' => '0', 'weekly_days' => '0', 'end_times' => '0' ]);
      $meeting->settings()->make([ 'join_before_host' => false, 'approval_type' => 0, 'registration_type' => 2, 'enforce_login' => false, 'auto_recording' => $request->is_recording ? 'cloud' : 'local' ]);
      $createMeeting = Zoom::user()->first()->meetings()->save($meeting);
      $zoonData = Zoom::user()->first()->meetings()->where('topic', $request->name)->get();
      $createRoom = Room::create([
        'name'                => $request->name,
        'start_date'          => new Carbon($request->start_date),
        'is_duration'         => $request->is_duration,
        'is_recording'        => $request->is_recording,
        'is_start_meeting'    => $request->is_start_meeting,
        'is_join_before_host' => false,
        'zoom_id'             => $zoonData[0]->id,
        'zoom_link'           => $zoonData[0]->join_url
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
    $findData = Zoom::user()->first()->meetings()->find($request->id);
    if ($findData) {
      Zoom::user()->first()->meetings()->find($request->id)->endMeeting();
      Room::where('zoom_id', $request->id)->update([ 'is_start_meeting' => 0 ]);
      Session::flash('success', 'Selamat, data meeting berhasil diberhentikan pada server!');
    } else {
      Session::flash('error', 'Maaf, data meeting tidak dapat diberhentikan. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.schedule.index');
  }

  public function delete(Request $request) {
    $findData = Zoom::user()->first()->meetings()->find($request->id);
    if ($findData) {
      Zoom::user()->first()->meetings()->find($request->id)->delete();
      Room::where('zoom_id', $request->id)->delete();
      Session::flash('success', 'Selamat, data meeting berhasil dihapus pada database server!');
    } else {
      Session::flash('error', 'Maaf, data meeting tidak dapat dihapus. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.schedule.index');
  }
}