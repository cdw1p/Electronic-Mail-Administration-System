<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
use App\Mail\ZoomMail;
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
      'dataUser' => User::select('name', 'email', 'user_telegram')->where('role', 'user')->where('status', 1)->get()
    ]);
  }

  public function store(Request $request) {
    $roomData = Room::where('zoom_id', $request->room_id)->first();
    foreach ($request->participants as $value) {
      $splitValue = explode('|', $value);
      $message = 'Halo '. $splitValue[2] .', anda di undang dalam acara "'. $roomData->name .'" yang akan diselanggarakan pada pukul '. $roomData->start_date .'. Link Zoom : ' .  $roomData->zoom_link;
      if (count($splitValue) > 2) {
        $email = $splitValue[1];
        $telegramSend = Http::get('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage?chat_id=' . $splitValue[0] .'&parse_mode=Markdown&text=' . $message);
        Mail::raw($message, function($msg) use ($email) {
          $msg->subject('Undangan Meeting Untuk Anda!')->to($email);
        });
      } else {
        $email = $splitValue[0];
        Mail::raw($message, function($msg) use ($email) {
          $msg->subject('Undangan Meeting Untuk Anda!')->to($email);
        });
      }
    }

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
    $deleteData = Invitation::where('room_id', $request->zoom_id)->delete();
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