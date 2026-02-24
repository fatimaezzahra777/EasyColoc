@extends('layouts.app')

@section('title','Ajouter dépense')

@section('content')

<h1 class="text-xl font-bold mb-4">Nouvelle dépense</h1>

<form method="POST"
      action="{{ route('dépenses.store',$colocation) }}"
      class="space-y-4">

@csrf

<input class="w-full border p-2" name="title" placeholder="Titre" required>

<input type="number" step="0.01" name="amount"
       class="w-full border p-2" placeholder="Montant" required>

<input type="date" name="expense_date"
       class="w-full border p-2" required>

<select name="category_id" class="w-full border p-2">
@foreach($categories as $category)
    <option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
</select>

<select name="payer_id" class="w-full border p-2">
@foreach($members as $member)
    <option value="{{ $member->user->id }}">
        {{ $member->user->name }}
    </option>
@endforeach
</select>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Enregistrer
</button>

</form>

@endsection