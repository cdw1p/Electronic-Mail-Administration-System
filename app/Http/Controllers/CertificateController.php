<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CertificateController extends Controller
{
  public function sign(Request $request) {
    $parameter = [
			'room_id'    => 'ROOM-001',
			'room_name'  => 'Android and Kotlin Developer Talk Indonesia 2021',
			'room_owner' => 'Android Dev Surabaya',
			'room_date'  => '2021-04-28 14:42:44',
		];
		$encryptParams = Crypt::encrypt($parameter);
		echo json_encode($parameter) . '<br><a href="/certificate/check/' . $encryptParams . '">Encrypt Parameter</a>';
  }

  public function check(Request $request) {
    try {
      $decryptParams = Crypt::decrypt($request->id);
      if ($decryptParams) {
        echo json_encode($decryptParams);
      } else {
        echo 'Invalid Sign';
      }
    } catch (DecryptException $e) {
      echo 'Invalid Sign';
    }
  }
}