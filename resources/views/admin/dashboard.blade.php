@extends('layouts.app')

@section('title', 'Administration')
@section('page-title', 'Administration')
@section('page-subtitle', 'Vue d\'ensemble de la plateforme')

@section('content')

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
        @php
            $stats = [
                ['label' => 'Utilisateurs',    'value' => $stats['users'] ?? 0,        'change' => '+12%', 'positive' => true,  'color' => 'bg-blue-500',   'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Colocations',     'value' => $stats['colocations'] ?? 0,   'change' => '+8%',  'positive' => true,  'color' => 'bg-emerald-500','icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['label' => 'Dépenses',        'value' => $stats['expenses'] ?? 0,      'change' => '+23%', 'positive' => true,  'color' => 'bg-amber-500',  'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Volume total',    'value' => number_format($stats['volume'] ?? 0, 2).' €', 'change' => '+18%', 'positive' => true, 'color' => 'bg-purple-500', 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-11 h-11 rounded-xl {{ $stat['color'] }} bg-opacity-10 flex items-center justify-center">
                        <svg class="w-5 h-5 {{ str_replace('bg-', 'text-', $stat['color']) }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold {{ $stat['positive'] ? 'text-emerald-600 bg-emerald-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full">
                        {{ $stat['change'] }}
                    </span>
                </div>
                <p class="text-2xl font-bold text-slate-800">{{ $stat['value'] }}</p>
                <p class="text-xs text-slate-500 mt-1 font-medium">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Users --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800 text-sm">Nouveaux utilisateurs</h3>
                <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Voir tous →
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentUsers ?? [] as $user)
                    <div class="flex items-center gap-3 px-6 py-3.5">
                        <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700 truncate">{{ $user->name }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                        </div>
                        <p class="text-xs text-slate-400 flex-shrink-0">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-500">Aucun utilisateur récent.</div>
                @endforelse
            </div>
        </div>

        {{-- Recent Expenses --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-semibold text-slate-800 text-sm">Dernières dépenses</h3>
                <a href="{{ route('expenses.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Voir toutes →
                </a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentExpenses ?? [] as $expense)
                    <div class="flex items-center gap-4 px-6 py-3.5">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700 truncate">{{ $expense->description }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $expense->colocation->name }} · {{ $expense->user->name }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-semibold text-slate-800">{{ number_format($expense->amount, 2) }} €</p>
                            <p class="text-xs text-slate-400">{{ $expense->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-sm text-slate-500">Aucune dépense récente.</div>
                @endforelse
            </div>
        </div>
    </div>

@endsection