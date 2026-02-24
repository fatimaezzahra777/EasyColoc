<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function ban(User $user)
    {
        $user->update(['is_banned' => true]);
        return redirect()->back()->with('success', 'Utilisateur banni avec succès.');
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);
        return redirect()->back()->with('success', 'Utilisateur débanni avec succès.');
    }
}

