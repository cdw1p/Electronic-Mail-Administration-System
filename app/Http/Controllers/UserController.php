<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

  public function create(Request $request) {
    $request->validate([
      'name'      => 'required',
      'email'     => 'required',
      'password'  => 'required'
    ]);
    $findUser = User::where('email', $request->email)->get();
    if (count($findUser) < 1) {
      User::create([
        'name'           => $request->name,
        'email'          => $request->email,
        'password'       => Hash::make($request->password),
        'role'           => 'user',
        'status'         => '1',
        'remember_token' => 'null'
      ]);
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }

  public function update(Request $request) {
    $request->validate([
      'name'      => 'required',
      'email'     => 'required',
      'password'  => 'required',
      'status'    => 'required'
    ]);
    $updateUser = User::where('email', $request->email)->update([
      'name'      => $request->name,
      'password'  => Hash::make($request->password),
      'status'    => $request->status
    ]);
    if ($updateUser) {
      return response()->json([ 'status' => true ]);
    } else {
      return response()->json([ 'status' => false ]);
    }
  }
}