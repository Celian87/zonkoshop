{{-- Risultati di ricerca --}}

@extends('layouts.app')

@section('title')
    Risultati ricerca: {{$search['text']}} - {{ config('app.name', 'ZonkoShop') }}
@append

@section('content')
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Risultati per "{{$search['text']}}"</h3>
        <div class="card-body card-deck">
            @forelse ($search['results'] as $product)
                @include('Store.common.prodtile', ['product' => $product])
            @empty
            <div class="card-body card-text">
                <p>Ci spiace, non abbiamo prodotti che corrispondono ai requisiti di ricerca</p>
                <p>Prova a controllare di aver digitato correttamente il nome dell'articolo o il prezzo</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
