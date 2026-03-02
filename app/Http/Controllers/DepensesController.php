<?php

namespace App\Http\Controllers;

use App\Models\Depenses;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepensesController extends Controller
{
    public function index(Colocation $colocation)
    {
        // très important : on affiche uniquement
        // les dépenses de cette colocation
        $depenses = Depenses::where('colocation_id', $colocation->id)
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('depenses.index', compact('colocation', 'depenses'));
    }
    public function create(Colocation $colocation)
    {
        $categories = $colocation->categories;

        $members = $colocation->users; 

        return view('depenses.create', compact(
            'colocation',
            'categories',
            'members'
        ));
    }

    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'montant'      => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'user_id'     => 'required|exists:users,id',
        ]);

        Depenses::create([
            'description'   => $request->description,
            'montant'        => $request->montant,
            'colocation_id' => $colocation->id,
            'category_id'   => $request->category_id,
            'user_id'       => $request->user_id, 
        ]);

        return redirect()->route('depenses.index', $colocation)
                        ->with('success', 'Dépense enregistrée !');
    }
}
