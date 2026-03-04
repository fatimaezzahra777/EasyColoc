<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;

class PaymentController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'from_user_id' => 'required|exists:users,id',
            'to_user_id'   => 'required|exists:users,id',
            'motant'       => 'required|numeric|min:0.01',
        ]);

        if (
            ! $colocation->users()->where('users.id', $request->from_user_id)->exists()
            || ! $colocation->users()->where('users.id', $request->to_user_id)->exists()
        ) {
            abort(403);
        }

        $colocation->payments()->create([
            'from_user_id' => $request->from_user_id,
            'to_user_id'   => $request->to_user_id,
            'motant'       => $request->motant,
        ]);

        return back()->with('success', 'Paiement enregistré');
    }
}
