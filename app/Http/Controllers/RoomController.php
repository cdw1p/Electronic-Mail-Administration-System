<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
  public function create(Request $request) {
    $request->validate([
      'name'                => 'required',
      'start_date'          => 'required',
      'end_date'            => 'required',
      'is_recording'        => 'required',
      'is_start_meeting'    => 'required',
      'is_join_before_host' => 'required'
    ]);
    $findRoom = Room::where($request->all())->get();
    if (count($findRoom) < 1) {
      Room::create($request->all());
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }
}