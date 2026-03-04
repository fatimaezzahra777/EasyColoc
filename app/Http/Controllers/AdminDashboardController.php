<?php

namespace App\Http\Controllers;

use App\Models\Depenses;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Colocation;



class AdminDashboardController extends Controller
{
    /* function pour retourner le view */
    

    /* function pour afficher les statistiques */
    public function index()
    {
        $stats = [
            'users'       => User::count(),
            'colocations' => Colocation::count(),
            'expenses'    => Depenses::count(),
            'volume'      => Depenses::sum('montant'),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}
