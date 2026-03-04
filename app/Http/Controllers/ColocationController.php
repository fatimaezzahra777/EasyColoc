<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Membership;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ColocationInvitationMail;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /* Cette fonction récupere uniquement les colocations l’utilisateur connecté appartient
     puis les affiche avec une pagination de 10 par page*/
    public function index()
    {
        $colocations = Colocation::whereHas('memberships', function ( $q) {
            $q->where('user_id', auth()->id());
        })->paginate(10);

        return view('colocations.index', compact('colocations'));
    }
    /**
     * Show the form for creating a new resource.
     */
    // Affiche le formulaire pour creer une nouvelle colocation appartenant a user connecte
    public function create()
    {
        $colocations = Colocation::where('owner_id', auth()->id())->get();

        return view('colocations.create', compact('colocations'));
    }
    /**
     * Store a newly created resource in storage.
     */
    //Valide et crée une nouvelle colocation et crée le membership de l'utilisateur en tant que owner
    //et empêche la création si l'utilisateur déjà dans une colocation
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $colocation = Colocation::create([
            'name' => $request->name,
            'owner_id' => auth()->id(),
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => auth()->id(),
            'colocation_id' => $colocation->id,
            'role' => 'owner',
        ]);

        if (auth()->user()->colocations()->exists()) {
            abort(403);
        }

        return redirect()->route('dashboard')
                        ->with('success', 'Colocation créée avec succès !');
    }
    /**
     * Display the specified resource.
     */
    //Affiche les detaille d'une colocation
    public function show(Colocation $colocation)
    {
        // Retourne la vue show
        return view('colocations.show', compact('colocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // affiche le view pour modifier une colocation
    public function edit(Colocation $colocation)
    {
        return view('colocations.edit', compact('colocation'));
    }

    /**
     * Update the specified resource in storage.
     */

    // Modifier un colocationn
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
    // Supprimer une colocation
    public function destroy(Colocation $colocation)
    {
        $colocation->delete();
        return redirect()->route('colocations.index')
                         ->with('success', 'Colocation supprimée !');
    }

    // Valide l'email crée une invitation pour la colocation envoie l'email au destinataire et affiche un message de succès
    public function sendInvitation(Request $request, Colocation $colocation)
    {
        
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

    public function leave(Colocation $colocation)
    {
        $user = auth()->user();

        $membership = $colocation->memberships()
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($membership->role === 'owner') {
            abort(403, 'Le propriétaire ne peut pas quitter la colocation.');
        }

        $membership->delete();

        return redirect()->route('colocations.index')
            ->with('success', 'Vous avez quitté la colocation.');
    }


}

