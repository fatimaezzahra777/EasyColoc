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
        $depenses = Depenses::with('category', 'user', 'colocation')
                ->where('colocation_id', $colocation->id)
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

    public function balances(Colocation $colocation)
    {
        $members = $colocation->users;

        $balances = [];

        foreach ($members as $user) {
            $balances[$user->id] = 0;
        }

        foreach ($colocation->depenses as $depense) {

            $payerId = $depense->user_id;

            if (!isset($balances[$payerId])) {
                continue;
            }

            $part = $depense->montant / $members->count();

            foreach ($members as $member) {

                if (!isset($balances[$member->id])) {
                    $balances[$member->id] = 0;
                }

                if ($member->id == $payerId) {
                    $balances[$member->id] += $depense->montant - $part;
                } else {
                    $balances[$member->id] -= $part;
                }
            }
        }

        $result = [];

        foreach ($members as $user) {
            $result[] = [
                'user'    => $user,
                'balance' => round($balances[$user->id], 2),
            ];
        }

        return view('balances.index', [
            'colocation' => $colocation,
            'balances'   => $result,
        ]);
    }
}
