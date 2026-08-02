<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApprovingOfficerController extends Controller
{
    public function index(){
        return view('approving-officer.dashboard');
    }
}
