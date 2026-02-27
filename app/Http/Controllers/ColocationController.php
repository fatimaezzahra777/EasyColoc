<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ColocationInvitationMail;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colocations = Colocation::paginate(10); 
        return view('colocations.index', compact('colocations'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colocations = Colocation::where('owner_id', auth()->id())->get();

        return view('colocations.create', compact('colocations'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Crée la colocation une seule fois
        $colocation = Colocation::create([
            'name' => $request->name,
            'owner_id' => auth()->id(),
            'status' => 'active',
        ]);

        // Crée le membership pour le propriétaire
        Membership::create([
            'user_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'role' => 'owner',
        ]);

        return redirect()->route('dashboard')
                        ->with('success', 'Colocation créée avec succès !');
    }
    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        // Retourne la vue show
        return view('colocations.show', compact('colocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $colocation->update($request->only('name'));

        return redirect()->route('colocations.show', $colocation)
                         ->with('success', 'Colocation mise à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index')
                         ->with('success', 'Colocation supprimée !');
    }
    public function sendInvitation(Request $request, Colocation $colocation)
    {
        $this->authorize('update', $colocation); 

        $request->validate([
            'email' => 'required|email'
        ]);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'email' => $request->email,
            'token' => Str::uuid(),
            'expires_at' => now()->addDays(3),
        ]);

        Mail::to($request->email)
            ->send(new ColocationInvitationMail($invitation));

        return back()->with('success', 'Invitation envoyée');
    }

}

