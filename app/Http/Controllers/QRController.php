<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use QrCode;

class QRController extends Controller
{
  public function generate(Request $request) {
    $parameter = [
			'room_id'    => 'ROOM-001',
			'room_name'  => 'Android and Kotlin Developer Talk Indonesia 2021',
			'room_owner' => 'Android Dev Surabaya',
			'room_date'  => '2021-04-28 14:42:44',
		];
		$encryptParams = Crypt::encrypt($parameter);
    return QrCode::size(250)->generate($encryptParams);
  }
}