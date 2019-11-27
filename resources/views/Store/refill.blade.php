@extends('layouts.app')

@section('title')
Rifornimento magazzino - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="box">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h1>Rifornimento magazzino</h1>
            <div class="card collapsable">
                <div class="card-header bg-light text-dark">
                    <div class="ml-auto d-flex justify-content-between align-items-center">
                        <span>
                            <h4 class="subtitle mx-auto w-100">Tutti i prodotti con meno di 5 unità</h4>
                        </span>
                        <span class="ml-auto pull-right">
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
                            <th>Stato</th>
                            <th>Rimasti</th>
                            <th>Venduti</th>
                        </tr>
                    </thead>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <a href="{{ action('ProductsController@show',$product) }}">
                                        {{ $product->name }}
                                </a>
                            </td>
                            <td>{{ $product->description }}</td>
                            <td class="{{ $product->quantity == 0 ? 'bg-danger text-white' : (($product->isDisabled()) ? "bg-dark text-white" : "bg-warning") }}">
                                {{ $product->quantity == 0 ? "ESAURITO" : (($product->isDisabled()) ? "Non acquistabile" : "In Esaurimento") }}
                            </td>
                            <td class="text-center">x{{ $product->quantity }}</td>
                            <td class="text-center">x{{ $product->sold() }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
