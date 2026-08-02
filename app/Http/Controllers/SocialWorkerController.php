<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialWorkerController extends Controller
{
    public function index(){
        return view('social-worker.dashboard');
    }
}
