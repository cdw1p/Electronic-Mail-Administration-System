<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Invitation;
use Session;

class MeetingInvititationController extends Controller
{
  public function index(Request $request) {
    return view('meeting/invitation_index', [
      'data' => Invitation::join('rooms', 'rooms.zoom_id', 'invitations.room_id')->get(),
      'dataRoom' => Room::select('name', 'zoom_id')->get(),
      'dataUser' => User::select('name', 'email')->where('role', 'user')->where('status', 1)->get()
    ]);
  }

  public function store(Request $request) {
    $findData = Invitation::where('room_id', $request->room_id)->first();
    if ($findData) {
      Invitation::where('room_id', $request->room_id)->update([
        'room_id'             => $request->room_id,
        'participants'        => json_encode($request->participants),
        'total_participants'  => count($request->participants)
      ]);
    } else {
      Invitation::create([
        'room_id'             => $request->room_id,
        'participants'        => json_encode($request->participants),
        'total_participants'  => count($request->participants)
      ]);
    }
    return redirect()->route('meeting.invitation.index');
  }

  public function delete(Request $request) {
    $deleteData = Invitation::where('room_id', $request->id)->delete();
    if ($deleteData) {
      Session::flash('success', 'Selamat, data undangan berhasil dihapus pada database server!');
    } else {
      Session::flash('error', 'Maaf, data undangan tidak dapat dihapus. Silahkan coba lagi!');
    }
    return redirect()->route('meeting.invitation.index');
  }

  public function getParticipants(Request $request) {
    return Invitation::select('participants')->where('room_id', $request->id)->get();
  }
}