<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        Gate::authorize('access-admin');

        return view('admin.dashboard');
    }

    


    
}
