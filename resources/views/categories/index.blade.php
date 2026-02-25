@extends('layouts.app')

@section('title', 'Catégories')
@section('page-title', 'Catégories')
@section('page-subtitle', 'Gérez les catégories de dépenses')

@section('header-actions')
    <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
            class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle catégorie
    </button>
@endsection

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($categories as $category)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-emerald-300 hover:shadow-md transition-all group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                         style="background-color: {{ $category->color ?? '#f0fdf4' }}20; border: 1px solid {{ $category->color ?? '#10b981' }}30;">
                        {{ $category->icon ?? '🏷️' }}
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->color ?? '' }}')"
                                class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-slate-800">{{ $category->name }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $category->expenses_count ?? 0 }} dépense(s)</p>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">🏷️</div>
                <p class="text-slate-500 text-sm mb-4">Aucune catégorie créée.</p>
                <button onclick="document.getElementById('modal-create').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Créer une catégorie
                </button>
            </div>
        @endforelse
    </div>

    {{-- Create Modal --}}
    <div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800">Nouvelle catégorie</h3>
                <button onclick="document.getElementById('modal-create').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 p-1 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('categories.store') }}" class="px-6 py-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-800 placeholder-slate-400 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition-all"
                           placeholder="Ex: Courses, Loyer, Internet...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Couleur</label>
                    <input type="color" name="color" value="{{ old('color', '#10b981') }}"
                           class="w-full h-12 rounded-xl border border-slate-200 cursor-pointer p-1">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')"
                            class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">Annuler</button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($errors->any() && old('_token'))
        <script>document.getElementById('modal-create').classList.remove('hidden');</script>
    @endif

@endsection