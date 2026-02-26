
@extends('layouts.app')

@section('title', 'Paiements')
@section('page-title', 'Paiements')
@section('page-subtitle', 'Suivez les remboursements entre colocataires')

@section('header-actions')
    <a href="{{ route('payments.create') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Enregistrer un paiement
    </a>
@endsection

@section('content')

    {{-- Balances --}}
    @if(isset($balances) && $balances->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-sm font-semibold text-slate-700 mb-3">Soldes actuels</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($balances as $balance)
                    <div class="bg-white rounded-2xl border {{ $balance->amount > 0 ? 'border-emerald-200' : ($balance->amount < 0 ? 'border-red-200' : 'border-slate-200') }} p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr($balance->user->name, 0, 1)) }}
                            </div>
                            <p class="text-sm font-medium text-slate-700">{{ $balance->user->name }}</p>
                        </div>
                        <p class="text-2xl font-bold {{ $balance->amount > 0 ? 'text-emerald-600' : ($balance->amount < 0 ? 'text-red-600' : 'text-slate-600') }}">
                            {{ $balance->amount > 0 ? '+' : '' }}{{ number_format($balance->amount, 2) }} €
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $balance->amount > 0 ? 'À recevoir' : ($balance->amount < 0 ? 'À payer' : 'Solde nul') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Payments list --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Historique des paiements</h3>
        </div>

        @forelse($payments ?? [] as $payment)
            <div class="flex items-center gap-4 px-6 py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                <div class="w-10 h-10 rounded-xl {{ $payment->status === 'completed' ? 'bg-emerald-50' : 'bg-amber-50' }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 {{ $payment->status === 'completed' ? 'text-emerald-600' : 'text-amber-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-medium text-slate-800">{{ $payment->payer->name }}</p>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                        <p class="text-sm font-medium text-slate-800">{{ $payment->receiver->name }}</p>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $payment->created_at->format('d M Y') }} · {{ $payment->colocation->name }}</p>
                </div>

                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-semibold text-slate-800">{{ number_format($payment->amount, 2) }} €</p>
                    @php
                        $sc = ['completed' => 'bg-emerald-100 text-emerald-700', 'pending' => 'bg-amber-100 text-amber-700'];
                        $sl = ['completed' => 'Complété', 'pending' => 'En attente'];
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $sc[$payment->status] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ $sl[$payment->status] ?? $payment->status }}
                    </span>
                </div>

                @if($payment->status === 'pending' && $payment->receiver_id === auth()->id())
                    <form method="POST" action="{{ route('payments.confirm', $payment) }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-lg transition-all flex-shrink-0">
                            Confirmer
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="py-16 text-center">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <p class="text-slate-500 text-sm">Aucun paiement enregistré.</p>
            </div>
        @endforelse
    </div>

@endsection