@extends('layouts.app')

@section('title', 'Enregistrer un paiement')
@section('page-title', 'Enregistrer un paiement')
@section('page-subtitle', 'Déclarez un remboursement entre colocataires')

@section('header-actions')
    <a href="{{ route('payments.index') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-50 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour
    </a>
@endsection

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">Détails du paiement</h2>
                <p class="text-sm text-slate-500 mt-1">Enregistrez un remboursement effectué entre membres.</p>
            </div>

            <form method="POST" action="{{ route('payments.store') }}" class="px-8 py-6 space-y-5">
                @csrf

                <div>
                    <label for="colocation_id" class="block text-sm font-medium text-slate-700 mb-1.5">Colocation <span class="text-red-500">*</span></label>
                    <select id="colocation_id" name="colocation_id" required
                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 outline-none transition-all bg-white border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <option value="">Sélectionner une colocation</option>
                        @foreach($colocations ?? [] as $coloc)
                            <option value="{{ $coloc->id }}" {{ old('colocation_id') == $coloc->id ? 'selected' : '' }}>{{ $coloc->name }}</option>
                        @endforeach
                    </select>
                    @error('colocation_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="receiver_id" class="block text-sm font-medium text-slate-700 mb-1.5">Paiement à <span class="text-red-500">*</span></label>
                    <select id="receiver_id" name="receiver_id" required
                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 outline-none transition-all bg-white border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <option value="">Sélectionner un colocataire</option>
                        @foreach($members ?? [] as $member)
                            <option value="{{ $member->id }}" {{ old('receiver_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-700 mb-1.5">Montant (€) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">€</span>
                        <input id="amount" type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0.01"
                               class="w-full pl-9 pr-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                      {{ $errors->has('amount') ? 'border-red-400 bg-red-50' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                               placeholder="0.00">
                    </div>
                    @error('amount')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="note" class="block text-sm font-medium text-slate-700 mb-1.5">Note (optionnel)</label>
                    <input id="note" type="text" name="note" value="{{ old('note') }}"
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                           placeholder="Remboursement loyer mars...">
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('payments.index') }}"
                       class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
                        Enregistrer le paiement
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection