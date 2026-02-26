<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
    {
        if (auth()->user()->is_global_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('dashboard.user');
    }
}
