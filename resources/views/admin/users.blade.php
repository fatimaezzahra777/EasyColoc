@extends('layouts.app')

@section('title','Gestion utilisateurs')

@section('content')

<h1 class="text-xl font-bold mb-4">Utilisateurs</h1>

<table class="w-full bg-white border rounded">
<thead>
<tr class="border-b">
    <th class="px-3 py-2 text-left">Nom</th>
    <th class="px-3 py-2 text-left">Email</th>
    <th class="px-3 py-2 text-left">Statut</th>
    <th class="px-3 py-2 text-left">Action</th>
</tr>
</thead>
<tbody>
@foreach($users as $user)
<tr class="border-b">
    <td class="px-3 py-2">{{ $user->name }}</td>
    <td class="px-3 py-2">{{ $user->email }}</td>
    <td class="px-3 py-2">
        @if($user->is_banned) <span class="text-red-600">Banni</span>
        @else <span class="text-green-600">Actif</span>
        @endif
    </td>
    <td class="px-3 py-2">
        @if(!$user->is_banned)
            <form method="POST" action="{{ route('admin.users.ban',$user) }}">
                @csrf
                <button class="text-red-600">Bannir</button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.users.unban',$user) }}">
                @csrf
                <button class="text-green-600">Débannir</button>
            </form>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>

@endsection