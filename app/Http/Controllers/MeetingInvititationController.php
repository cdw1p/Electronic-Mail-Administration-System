<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
use App\Models\Room;
use Session;

class MeetingInvititationController extends Controller
{
  public function index(Request $request) {
    return view('meeting/invitation_index', ['data' => Room::all()]);
  }
}