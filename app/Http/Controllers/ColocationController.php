<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;

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
        return view('colocations.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Colocation::create([
            'name' => $request->name,
            'owner_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Colocation créée avec succès !');
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
}
