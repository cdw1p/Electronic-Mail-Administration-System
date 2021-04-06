<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;

class ZoomController extends Controller
{
  public function getUser() {
    return Zoom::user()->first();
  }

  public function getMeeting() {
    return Zoom::user()->first()->meetings()->get();
  }

  public function createMeeting() {
    $meeting = Zoom::meeting()->make([ 'topic' => 'Test Meeting', 'type' => 8, 'start_time' => new Carbon('2021-04-04 10:00:00') ]);
    $meeting->recurrence()->make([ 'type' => 2, 'repeat_interval' => '0', 'weekly_days' => '0', 'end_times' => '0' ]);
    $meeting->settings()->make([ 'join_before_host' => true, 'approval_type' => 0, 'registration_type' => 2, 'enforce_login' => false ]);
    Zoom::user()->first()->meetings()->save($meeting);
    return response()->json([ 'status' => true ]);
  }
}