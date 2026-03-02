<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Colocation $colocation)
    {
        $categories = $colocation->categories; // récupère toutes les catégories de la coloc
        return view('categories.index', compact('colocation', 'categories'));
    }

    public function create(Colocation $colocation)
    {
        return view('categories.create', compact('colocation'));
    }
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

    public function destroy(Category $category)
    {
        

        if ($category->depenses()->exists()) {
            return back()->withErrors('Cette catégorie est utilisée.');
        }

        $category->delete();

        return back();
    }



}
