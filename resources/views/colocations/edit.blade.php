@extends('layouts.app')

@section('title', 'Modifier la colocation')
@section('page-title', 'Modifier la colocation')
@section('page-subtitle', $colocation->name)

@section('header-actions')
    <a href="{{ route('colocations.show', $colocation) }}"
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
                <h2 class="text-lg font-semibold text-slate-800">Modifier les informations</h2>
                <p class="text-sm text-slate-500 mt-1">Mettez à jour les détails de votre colocation.</p>
            </div>

            <form method="POST" action="{{ route('colocations.update', $colocation) }}" class="px-8 py-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom de la colocation <span class="text-red-500">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name', $colocation->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                  {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all resize-none
                                     {{ $errors->has('description') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">{{ old('description', $colocation->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse</label>
                    <input id="address" type="text" name="address" value="{{ old('address', $colocation->address) }}"
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                  {{ $errors->has('address') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100 focus:border-red-500' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">
                    @error('address')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2 flex items-center justify-between border-t border-slate-100">
                    <form method="POST" action="{{ route('colocations.destroy', $colocation) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette colocation ? Cette action est irréversible.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium transition-colors flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('colocations.show', $colocation) }}"
                           class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection