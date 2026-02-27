@extends('layouts.app')

@section('title', 'Invitations')
@section('page-title', 'Invitations')
@section('page-subtitle', 'Gérez vos invitations de colocation')

@section('header-actions')
    <a href="{{ route('invitations.create', $colocation) }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.97]">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Envoyer une invitation
    </a>
@endsection

@section('content')

    {{-- Pending invitations received --}}
    @if(isset($received) && $received->isNotEmpty())
        <div class="mb-6">
            <h2 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                Invitations reçues ({{ $received->count() }})
            </h2>
            <div class="space-y-3">
                @foreach($received as $invitation)
                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Invitation à rejoindre <span class="text-amber-700">{{ $invitation->colocation->name }}</span></p>
                                <p class="text-xs text-slate-500 mt-0.5">De la part de {{ $invitation->sender->name }} · {{ $invitation->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <form method="POST" action="{{ route('invitations.accept', $invitation) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-semibold rounded-xl transition-all">
                                    Accepter
                                </button>
                            </form>
                            <form method="POST" action="{{ route('invitations.decline', $invitation) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-medium rounded-xl transition-all">
                                    Refuser
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Sent invitations --}}
    <div>
        <h2 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
            <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
            Invitations envoyées
        </h2>
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            @forelse($sent ?? [] as $invitation)
                <div class="flex items-center gap-4 px-6 py-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800">{{ $invitation->email }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $invitation->colocation->name }} · {{ $invitation->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        @php
                            $statusConfig = [
                                'pending'  => ['bg-amber-100 text-amber-700',   'En attente'],
                                'accepted' => ['bg-emerald-100 text-emerald-700', 'Acceptée'],
                                'declined' => ['bg-red-100 text-red-700',       'Refusée'],
                            ];
                            [$cls, $label] = $statusConfig[$invitation->status] ?? ['bg-slate-100 text-slate-600', 'Inconnu'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $cls }}">
                            {{ $label }}
                        </span>
                        @if($invitation->status === 'pending')
                            <form method="POST" action="{{ route('invitations.cancel', $invitation) }}" onsubmit="return confirm('Annuler cette invitation ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-16 text-center">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-500 text-sm">Aucune invitation envoyée pour l'instant.</p>
                </div>
            @endforelse
        </div>
    </div>

@endsection