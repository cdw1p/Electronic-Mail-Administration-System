<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
use App\Models\Room;

class ZoomController extends Controller
{
  public function getUser() {
    return Zoom::user()->first();
  }

  public function getMeeting() {
    // return Zoom::user()->first()->meetings()->get();
    return Room::paginate(10);
  }

  public function createMeeting() {
    $findDatabase = Room::where('name', 'Test Meeting')->first();
    $findZoomData = Zoom::user()->first()->meetings()->where('topic', 'Test Meeting')->get();
    if (!$findDatabase && count($findZoomData) < 1) {
      $meeting = Zoom::meeting()->make([ 'topic' => 'Test Meeting', 'type' => 8, 'start_time' => new Carbon('2021-04-04 10:00:00') ]);
      $meeting->recurrence()->make([ 'type' => 2, 'repeat_interval' => '0', 'weekly_days' => '0', 'end_times' => '0' ]);
      $meeting->settings()->make([ 'join_before_host' => true, 'approval_type' => 0, 'registration_type' => 2, 'enforce_login' => false ]);
      $createMeeting = Zoom::user()->first()->meetings()->save($meeting);
      $zoonData = Zoom::user()->first()->meetings()->where('topic', 'Test Meeting')->get();
      $createRoom = Room::create([
        'name' => 'Test Meeting',
        'start_date' => new Carbon('2021-04-04 10:00:00'),
        'end_date' => new Carbon('2021-04-04 10:00:00'),
        'is_recording' => false,
        'is_start_meeting' => true,
        'is_join_before_host' => true,
        'zoom_id' => $zoonData[0]->id,
        'zoom_link' => $zoonData[0]->join_url
      ]);
      if ($createMeeting && $createRoom) {
        return response()->json([ 'status' => true ]);
      } else {
        return response()->json([ 'status' => false, 'message' => 'Something error when created new meeting room.' ]);
      }
    } else {
      return response()->json([ 'status' => false, 'message' => 'Data is already exists.' ]);
    }
  }

  public function endMeeting(Request $request) {
    $findData = Zoom::user()->first()->meetings()->find($request->id);
    if ($findData) {
      Zoom::user()->first()->meetings()->find($request->id)->endMeeting();
      Room::where('zoom_id', $request->id)->update([ 'is_start_meeting' => 0 ]);
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }

  public function deleteMeeting(Request $request) {
    $findData = Zoom::user()->first()->meetings()->find($request->id);
    if ($findData) {
      Zoom::user()->first()->meetings()->find($request->id)->delete();
      Room::where('zoom_id', $request->id)->delete();
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }
}