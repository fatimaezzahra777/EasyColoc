<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Colocation $colocation)
    {
        // récupère toutes les catégories de la colocation
        $categories = $colocation->categories; 
        return view('categories.index', compact('colocation', 'categories'));
    }

    // cette function juste pour afficher le view create
    public function create(Colocation $colocation)
    {
        return view('categories.create', compact('colocation'));
    }

    //cette function pour creer un categorie obligatoire entrer le nom est un nom unique dans la colocation 
    public function store(Request $request, Colocation $colocation)
    {

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'unique:categories,name,NULL,id,colocation_id,' . $colocation->id,
            ],
        ]);

        $colocation->categories()->create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Catégorie ajoutée avec succès.');
    }

    // cette function pour supprimer un categorie i il n'existe pas dans une depense
    public function destroy(Category $category)
    {

        if ($category->depenses()->exists()) {
            return back()->withErrors('Cette catégorie est utilisée.');
        }

        $category->delete();

        return back();
    }



}
