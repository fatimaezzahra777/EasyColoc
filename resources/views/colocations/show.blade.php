@extends('layouts.app')

@section('title',$colocation->name)

@section('content')

<h1 class="text-2xl font-bold mb-4">{{ $colocation->name }}</h1>

<h2 class="font-semibold mb-2">Membres</h2>
<ul class="mb-6">
@foreach($members as $member)
    <li>
        {{ $member->user->name }} ({{ $member->role }})
    </li>
@endforeach
</ul>

<a href="{{ route('dépenses.index',$colocation) }}"
   class="text-blue-600 underline">Voir les dépenses</a>

@endsection