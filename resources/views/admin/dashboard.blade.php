@extends('layouts.app')

@section('title','Admin dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

<ul class="space-y-2">
    <li>Utilisateurs : {{ $stats['users'] }}</li>
    <li>Colocations : {{ $stats['colocations'] }}</li>
    <li>Dépenses : {{ $stats['expenses'] }}</li>
    <li>Utilisateurs bannis : {{ $stats['banned_users'] }}</li>
</ul>

<a href="{{ route('admin.users.index') }}" 
   class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">
   Gestion des utilisateurs
</a>
@endsection