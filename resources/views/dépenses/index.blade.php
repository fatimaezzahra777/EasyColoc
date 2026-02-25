@extends('layouts.app')

@section('title', 'Dépenses')
@section('page-title', 'Dépenses')
@section('page-subtitle', 'Toutes les dépenses partagées')

@section('header-actions')
    <a href="{{ route('expenses.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter une dépense
    </a>
@endsection

@section('content')

    {{-- Filter bar --}}
    <form method="GET" class="flex flex-wrap items-center gap-3 mb-6 bg-white rounded-2xl border border-slate-200 px-5 py-4">
        <div class="flex-1 min-w-48">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une dépense..."
                   class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition-all">
        </div>
        <div>
            <select name="colocation_id" class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:border-emerald-400 transition-all bg-white">
                <option value="">Toutes les colocations</option>
                @foreach($colocations ?? [] as $coloc)
                    <option value="{{ $coloc->id }}" {{ request('colocation_id') == $coloc->id ? 'selected' : '' }}>
                        {{ $coloc->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="category_id" class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:border-emerald-400 transition-all bg-white">
                <option value="">Toutes les catégories</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-all">
            Filtrer
        </button>
        @if(request()->hasAny(['search','colocation_id','category_id']))
            <a href="{{ route('expenses.index') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">Réinitialiser</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800 text-sm">{{ $expenses->total() ?? 0 }} dépense(s)</h3>
            <p class="text-sm font-semibold text-slate-700">Total : <span class="text-emerald-600">{{ number_format($total ?? 0, 2) }} €</span></p>
        </div>

        @if($expenses->isEmpty())
            <div class="py-16 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-slate-500 text-sm">Aucune dépense trouvée.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Description</th>
                            <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Colocation</th>
                            <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Catégorie</th>
                            <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Payé par</th>
                            <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Date</th>
                            <th class="text-right text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Montant</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($expenses as $expense)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-800">{{ $expense->description }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">{{ $expense->colocation->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($expense->category)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                            {{ $expense->category->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                            {{ strtoupper(substr($expense->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-slate-600">{{ $expense->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-500">{{ $expense->created_at->format('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-semibold text-slate-800">{{ number_format($expense->amount, 2) }} €</span>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" onsubmit="return confirm('Supprimer cette dépense ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $expenses->withQueryString()->links() }}
            </div>
        @endif
    </div>

@endsection