<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ColocationInvitationMail;


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

    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => (string) Str::uuid(),
        ]);

        Mail::to($request->email)->send(new ColocationInvitationMail($invitation));

        return redirect()
            ->route('invitations.index', $colocation)
            ->with('success', 'Invitation envoyée');
    }
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)
                
                                ->firstOrFail();

        Membership::create([
            'user_id' => auth()->id(),
            'colocation_id' => $invitation->colocation_id,
            'role' => 'member',
        ]);

        $invitation->delete();

        return redirect()->route('dashboard')->with('success', 'Vous avez rejoint la colocation !');
    }
}
