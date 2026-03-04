@extends('layouts.nav')

@section('title', 'Gestion des utilisateurs')
@section('page-title', 'Utilisateurs')
@section('page-subtitle', 'Gérez les comptes de la plateforme')

@section('content')

    {{-- Search --}}
    <form method="GET" class="flex items-center gap-3 mb-6 bg-white rounded-2xl border border-slate-200 px-5 py-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom ou email..."
                   class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition-all">
        </div>
        <div>
            <select name="role" class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-700 focus:outline-none focus:border-emerald-400 transition-all bg-white">
                <option value="">Tous les rôles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrateurs</option>
                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Utilisateurs</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-medium rounded-xl hover:bg-slate-700 transition-all">
            Filtrer
        </button>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">{{ $users->count() }} utilisateur(s)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Utilisateur</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Rôle</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Colocations</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Inscription</th>
                        <th class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wider px-6 py-3">Statut</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-500 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    Utilisateur
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $user->colocations_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500">{{ $user->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->is_banned)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Banni
                                    </span>
                                @elseif($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        Vérifié
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        Non vérifié
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 justify-end">

                                    {{-- Ban / Unban --}}
                                    @if(!$user->is_banned)
                                        <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs">
                                                Bannir
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.unban', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-lg text-xs">
                                                Débannir
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <p class="text-slate-500 text-sm">Aucun utilisateur trouvé.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>

@endsection