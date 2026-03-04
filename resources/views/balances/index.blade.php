@extends('layouts.app')

@section('title','Balances')

@section('content')

<div class="max-w-xl mx-auto bg-white rounded-xl border p-6">

    <h2 class="text-lg font-semibold mb-4">
        Qui doit à qui – {{ $colocation->name }}
    </h2>

    {{-- TABLE DES BALANCES --}}
    <table class="w-full mb-6">
        <thead>
        <tr class="text-left text-sm text-slate-500">
            <th>Membre</th>
            <th class="text-right">Balance</th>
            <th class="text-center">Réputation</th>
        </tr>
        </thead>

        <tbody class="divide-y">

        @foreach($balances as $userId => $row)
            <tr>
                <td class="py-2">
                    {{ $row['user']->name }}
                </td>

                <td class="py-2 text-right font-semibold
                    {{ $row['balance'] < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                    {{ number_format($row['balance'],2) }} €
                </td>
                 <td class="py-2 text-center font-semibold">
                    @if($row['balance'] > 0)
                        <span class="text-emerald-600">+1</span>
                    @elseif($row['balance'] < 0)
                        <span class="text-red-600">-1</span>
                    @else
                        <span class="text-slate-400">0</span>
                     @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>


    {{-- FORMULAIRE DE PAIEMENT --}}
    <h3 class="text-sm font-semibold mb-2">
        Marquer un paiement
    </h3>

    <form method="POST"
          action="{{ route('payments.store', $colocation) }}"
          class="space-y-3">

        @csrf

        {{-- from user = connecté --}}
        <input type="hidden" name="from_user_id" value="{{ auth()->id() }}">

        <div>
            <label class="text-sm">Payer à</label>

            <select name="to_user_id"
                    required
                    class="w-full border rounded px-3 py-2">

                <option value="">Choisir un membre</option>

                @foreach($balances as $row)
                    @if($row['user']->id !== auth()->id())
                        <option value="{{ $row['user']->id }}">
                            {{ $row['user']->name }}
                        </option>
                    @endif
                @endforeach

            </select>
        </div>

        <div>
            <label class="text-sm">Montant</label>

            <input type="number"
                   step="0.01"
                   min="0.01"
                   name="motant"
                   required
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit"
                class="px-4 py-2 bg-emerald-600 text-white rounded">
            Marquer payé
        </button>

    </form>

</div>

@endsection