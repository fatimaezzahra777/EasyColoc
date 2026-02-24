@extends('layouts.app')

@section('title','Dépenses')

@section('content')
<h1 class="text-xl font-bold mb-4">Dépenses</h1>

<form method="GET" class="mb-4">
    <input type="month" name="month" value="{{ request('month') }}">
    <button class="px-3 py-1 bg-gray-800 text-white rounded">Filtrer</button>
</form>

<a href="{{ route('dépenses.create',$colocation) }}"
   class="px-3 py-2 bg-blue-600 text-white rounded">Ajouter</a>

<table class="w-full mt-4 bg-white">
<thead>
<tr class="border-b">
    <th>Titre</th>
    <th>Montant</th>
    <th>Payeur</th>
</tr>
</thead>
<tbody>
@foreach($expenses as $expense)
<tr class="border-b">
    <td>{{ $expense->title }}</td>
    <td>{{ $expense->amount }}</td>
    <td>{{ $expense->payer->name }}</td>
</tr>
@endforeach
</tbody>
</table>

@endsection