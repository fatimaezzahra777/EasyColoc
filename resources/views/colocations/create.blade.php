@extends('layouts.app')

@section('title', 'Nouvelle colocation')
@section('page-title', 'Nouvelle colocation')
@section('page-subtitle', 'Créez votre espace de colocation partagé')

@section('header-actions')
    <a href="{{ route('colocations.index') }}"
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
                <h2 class="text-lg font-semibold text-slate-800">Informations de la colocation</h2>
                <p class="text-sm text-slate-500 mt-1">Remplissez les détails pour créer votre colocation.</p>
            </div>

            <form method="POST" action="{{ route('colocations.store') }}" class="px-8 py-6 space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom de la colocation <span class="text-red-500">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                  {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                           placeholder="Ex: Coloc du 5ème arrondissement">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all resize-none
                                     {{ $errors->has('description') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                              placeholder="Une brève description de votre colocation...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse</label>
                    <input id="address" type="text" name="address" value="{{ old('address') }}"
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                  {{ $errors->has('address') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                           placeholder="123 Rue de la Paix, 75001 Paris">
                    @error('address')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('colocations.index') }}"
                       class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
                        Créer la colocation
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection