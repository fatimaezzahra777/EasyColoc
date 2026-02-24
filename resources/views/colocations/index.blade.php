@extends('layouts.app')

@section('title','Mes colocations')

@section('content')
<h1 class="text-2xl font-bold mb-4">Mes colocations</h1>

<a href="{{ route('colocations.create') }}"
   class="px-4 py-2 bg-blue-600 text-white rounded">Nouvelle colocation</a>

<div class="mt-4 space-y-3">
@foreach($colocations as $colocation)
    <div class="p-4 bg-white rounded shadow">
        <a class="font-semibold"
           href="{{ route('colocations.show',$colocation) }}">
            {{ $colocation->name }}
        </a>
    </div>
@endforeach
</div>
@endsection