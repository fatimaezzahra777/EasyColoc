@extends('layouts.app')

@section('title', 'Nouvelle dépense')
@section('page-title', 'Nouvelle dépense')
@section('page-subtitle', 'Enregistrez une dépense partagée')

@section('header-actions')
    <a href="{{ route('depenses.index', $colocation) }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-50 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour
    </a>
@endsection

@section('content')

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100">
                <h2 class="text-lg font-semibold text-slate-800">Détails de la dépense</h2>
                <p class="text-sm text-slate-500 mt-1">Renseignez les informations de votre dépense.</p>
            </div>

            <form method="POST" action="{{ route('depenses.store', ['colocation' => $colocation->id]) }}" class="px-8 py-6 space-y-5">
                @csrf

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                    <input id="description" type="text" name="description" value="{{ old('description') }}" required
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                  {{ $errors->has('description') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                           placeholder="Ex: Courses alimentaires, Facture électricité...">
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Amount --}}
                <div>
                    <label for="montant" class="block text-sm font-medium text-slate-700 mb-1.5">Montant (€) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">€</span>
                        <input id="montant" type="number" name="montant" value="{{ old('montant') }}" required step="0.01" min="0"
                               class="w-full pl-9 pr-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                      {{ $errors->has('montant') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                               placeholder="0.00">
                    </div>
                    @error('montant')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Colocation --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Colocation
                    </label>

                    <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                    <div class="px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700">
                        {{ $colocation->name }}
                    </div>
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label class="form-label">Catégorie</label>

                    <select name="category_id" class="form-select" required>
                        <option value="">-- Choisir une catégorie --</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Membre concerné --}}
               
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Membre
                    </label>

                    {{-- Input caché pour envoyer l'id --}}
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    {{-- Affichage du nom --}}
                    <div class="px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700">
                        {{ auth()->user()->name }}
                    </div>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('depenses.index', $colocation) }}"
                       class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
                        Enregistrer la dépense
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection