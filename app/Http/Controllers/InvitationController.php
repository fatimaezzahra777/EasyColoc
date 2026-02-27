<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Colocation;
use App\Models\Membership;

class InvitationController extends Controller
{
    public function create(Colocation $colocation)
    {
        return view('invitations.create', compact('colocation'));
    }

    public function index(Colocation $colocation)
    {
        $invitations = Invitation::where('colocation_id', $colocation->id)
            ->latest()
            ->get();

        return view('invitations.index', compact('colocation', 'invitations'));
    }
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
                                ->where('expires_at', '>', now())
                                ->firstOrFail();

        // Ajouter le membre à la colocation
        Membership::create([
            'user_id' => auth()->id(),
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
        ]);

        // Supprimer l’invitation
        $invitation->delete();

        return redirect()->route('dashboard')->with('success', 'Vous avez rejoint la colocation !');
    }
}
