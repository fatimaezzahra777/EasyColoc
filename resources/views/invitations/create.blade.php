@extends('layouts.app')

@section('title', 'Inviter un colocataire')
@section('page-title', 'Inviter un colocataire')
@section('page-subtitle', 'Envoyez une invitation par e-mail')

@section('header-actions')
    <a href="{{ route('invitations.index', $colocation) }}"
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
                <h2 class="text-lg font-semibold text-slate-800">Envoyer une invitation</h2>
                <p class="text-sm text-slate-500 mt-1">Votre colocataire recevra un lien par e-mail pour rejoindre la colocation.</p>
            </div>

            <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="px-8 py-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse e-mail <span class="text-red-500">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all
                                  {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:ring-2 focus:ring-red-100' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                           placeholder="colocataire@exemple.com">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="colocation_id" class="block text-sm font-medium text-slate-700 mb-1.5">Colocation <span class="text-red-500">*</span></label>
                    <select id="colocation_id" name="colocation_id" required
                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 outline-none transition-all bg-white
                                   {{ $errors->has('colocation_id') ? 'border-red-400 bg-red-50' : 'border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">
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

                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700 mb-1.5">Message personnalisé (optionnel)</label>
                    <textarea id="message" name="message" rows="3"
                              class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 outline-none transition-all resize-none border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                              placeholder="Un message d'accueil pour votre futur colocataire...">{{ old('message') }}</textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('invitations.index', $colocation) }}"
                       class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Annuler
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Envoyer l'invitation
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection