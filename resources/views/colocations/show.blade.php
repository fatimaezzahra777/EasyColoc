@extends('layouts.app')

@section('title', $colocation->name)
@section('page-title', $colocation->name)
@section('page-subtitle', 'Détails de la colocation')

@section('header-actions')
    <a href="{{ route('colocations.edit', $colocation) }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-50 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
        </svg>
        Modifier
    </a>
    <a href="{{ route('invitations.create', ['colocation' => $colocation->id]) }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        Inviter
    </a>
@endsection

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Membres', 'value' => $colocation->memberships->count(), 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'bg-blue-50 text-blue-600'],
                ['label' => 'Dépenses', 'value' => $colocation->dépenses->count(), 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'bg-amber-50 text-amber-600'],
                ['label' => 'Total dépenses', 'value' => number_format($colocation->dépenses->sum('amount'), 2).' €', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'bg-emerald-50 text-emerald-600'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $stat['color'] }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-800 mt-0.5">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Members --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800 text-sm">Membres</h3>
                    <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">{{ $colocation->memberships->count() }}</span>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($colocation->memberships as $member)
                        <div class="flex items-center gap-3 px-6 py-3.5">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700 truncate">{{ $member->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ $member->email }}</p>
                            </div>
                            @if($member->id === $colocation->owner_id)
                                <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-medium flex-shrink-0">Admin</span>
                            @endif
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center">
                            <p class="text-sm text-slate-500">Aucun membre pour l'instant.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800 text-sm">Dernières dépenses</h3>
                    <a href="{{ route('dépenses.create', ['colocation' => $colocation->id]) }}"
                       class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Ajouter
                    </a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($colocation->dépenses->take(8) as $dépenses)
                        <div class="flex items-center gap-4 px-6 py-3.5">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4.5 h-4.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700 truncate">{{ $dépenses->description }}</p>
                                <p class="text-xs text-slate-400">{{ $dépenses->user->name }} · {{ $dépenses->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-semibold text-slate-800">{{ number_format($dépenses->amount, 2) }} €</p>
                                @if($dépenses->category)
                                    <span class="text-xs text-slate-400">{{ $dépenses->category->name }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-slate-500">Aucune dépense enregistrée.</p>
                        </div>
                    @endforelse
                </div>
                @if($colocation->dépenses->count() > 8)
                    <div class="px-6 py-3 bg-slate-50 border-t border-slate-100">
                        <a href="{{ route('dépenses.index', ['colocation' => $colocation->id]) }}"
                           class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Voir toutes les dépenses →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection