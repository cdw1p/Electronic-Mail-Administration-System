<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \MacsiDigital\Zoom\Facades\Zoom;

class ZoomController extends Controller
{
  public function getUser() {
    return Zoom::user()->all();
  }
}