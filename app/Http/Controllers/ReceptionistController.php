<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Queue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function index(){
        return view('receptionist.dashboard');
    }
    
}
