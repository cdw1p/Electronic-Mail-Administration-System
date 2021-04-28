<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
  public function get(Request $request) {
    $getRoom = Room::paginate(15);
    if ($getRoom) {
      return response()->json([ 'status' => true, 'data' => $getRoom ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }
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

  public function update(Request $request) {
    $request->validate([
      'id_rooms'            => 'required',
      'name'                => 'required',
      'start_date'          => 'required',
      'end_date'            => 'required',
      'is_recording'        => 'required',
      'is_start_meeting'    => 'required',
      'is_join_before_host' => 'required'
    ]);
    $updateRoom = Room::where('id_rooms', $request->id_rooms)->update($request->all());
    if ($updateRoom) {
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }

  public function delete(Request $request) {
    $request->validate([
      'id_rooms'            => 'required',
    ]);
    $deleteRoom = Room::where('id_rooms', $request->id_rooms)->delete();
    if ($deleteRoom) {
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }
}