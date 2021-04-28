<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  public function get(Request $request) {
    $getRoom = User::paginate(15);
    if ($getRoom) {
      return response()->json([ 'status' => true, 'data' => $getRoom ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }
}