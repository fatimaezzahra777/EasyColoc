@extends('layouts.app')

@section('title', 'Nouvelle dépense')
@section('page-title', 'Nouvelle dépense')
@section('page-subtitle', 'Enregistrez une dépense partagée')

@section('header-actions')
    <a href="{{ route('expenses.index') }}"
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

            <form method="POST" action="{{ route('expenses.store') }}" class="px-8 py-6 space-y-5">
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
                    <label for="amount" class="block text-sm font-medium text-slate-700 mb-1.5">Montant (€) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">€</span>
                        <input id="amount" type="number" name="amount" value="{{ old('amount') }}" required step="0.01" min="0"
                               class="w-full pl-9 pr-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                      {{ $errors->has('amount') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                               placeholder="0.00">
                    </div>
                    @error('amount')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Colocation --}}
                <div>
                    <label for="colocation_id" class="block text-sm font-medium text-slate-700 mb-1.5">Colocation <span class="text-red-500">*</span></label>
                    <select id="colocation_id" name="colocation_id" required
                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 outline-none transition-all bg-white
                                   {{ $errors->has('colocation_id') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">
                        <option value="">Sélectionner une colocation</option>
                        @foreach($colocations ?? [] as $coloc)
                            <option value="{{ $coloc->id }}" {{ old('colocation_id', request('colocation')) == $coloc->id ? 'selected' : '' }}>
                                {{ $coloc->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('colocation_id')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">Catégorie</label>
                    <select id="category_id" name="category_id"
                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 outline-none transition-all bg-white border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100">
                        <option value="">Sans catégorie</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Split type --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Répartition</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['equal' => 'Égale', 'percentage' => 'Par pourcentage', 'custom' => 'Personnalisée', 'single' => 'Payeur unique'] as $value => $label)
                            <label class="flex items-center gap-3 p-3.5 rounded-xl border cursor-pointer transition-all
                                          {{ old('split_type', 'equal') === $value ? 'border-emerald-400 bg-emerald-50' : 'border-slate-200 hover:border-slate-300' }}">
                                <input type="radio" name="split_type" value="{{ $value }}"
                                       class="w-4 h-4 text-emerald-500 border-slate-300 focus:ring-emerald-400"
                                       {{ old('split_type', 'equal') === $value ? 'checked' : '' }}>
                                <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Note --}}
                <div>
                    <label for="note" class="block text-sm font-medium text-slate-700 mb-1.5">Note (optionnel)</label>
                    <textarea id="note" name="note" rows="3"
                              class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all resize-none border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                              placeholder="Informations supplémentaires...">{{ old('note') }}</textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('expenses.index') }}"
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