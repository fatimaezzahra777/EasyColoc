<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Models\Depenses;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /* afficher les users avec les vraies infos */

    public function index(Request $request)
    {
        $query = User::query();
        $query->where('is_global_admin', false);
        $query->withCount('colocations');
            
        
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->get();
        $stats = [
            'users'       => User::count(),
            'colocations' => Colocation::count(),
            'expenses'    => Depenses::count(),
            'volume'      => Depenses::sum('montant'),
        ];

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.users', compact('users', 'stats',  'recentUsers'));
    }

    /* bannir */
    public function ban(User $user)
    {
        $user->update([
            'is_banned' => true
        ]);

        return back()->with('success', 'Utilisateur banni avec succès.');
    }

    /* débannir */
    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false
        ]);

        return back()->with('success', 'Utilisateur débanni avec succès.');
    }
}