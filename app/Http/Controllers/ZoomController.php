<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;

class ZoomController extends Controller
{
  public function getUser() {
    return Zoom::user()->first();
  }

  public function getMeeting() {
    return Zoom::user()->first()->meetings()->get();
  }
}