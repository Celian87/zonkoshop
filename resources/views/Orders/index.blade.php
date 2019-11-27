{{-- Mostra gli ordini dell'utente loggato --}}

@extends('layouts.app')

@section('title')
I tuoi ordini - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<h1>I tuoi ordini</h1>

<div class="card-deck">
    @foreach ($orders as $order)
    <div class="card collapsable mb-4">
        <div class="card-header bg-light text-dark">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <h3 class="subtitle">Ordine #{{ $order->id }}</h3>
                    <div>Effettuato il {{ $order->created_at->format('d-m-Y') }}</div>
                </span>
                <span class="float pull-right">
                    <span><i class="fas fa-angle-up"></i></span>
                    <span><i class="fas fa-angle-down d-none"></i></span>
                </span>
            </div>
        </div>
        <div class="card-body bg-white">
            <table class="table">
                <thead>
                    <tr>
                        <th>Prodotto</th>
                        <th>Descrizione</th>
                        <th>Quantità ordinata</th>
                    </tr>
                </thead>
                @foreach ($order->products as $product)
                {{-- @include('Store.common.prodtile', ['product' => $product]) --}}
                    <tr>
                        <td>
                            @if ($product->isDisabled())
                            <span class="text-disabled">
                                {{ $product->name }}
                            </span>
                            @else
                            <a href="{{ action('ProductsController@show',$product) }}">
                                    {{ $product->name }}
                            </a>
                            @endif
                        </td>
                        <td>{{ $product->description }}</td>
                        <td class="align-text-center">x{{ $product->ordered->quantity }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection
