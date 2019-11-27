@extends('layouts.app')

@section('title')
Admin Dashboard - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<h1>Dashboard di Amministrazione</h1>

@php
    $categories = App\Category::orderBy('name')->get();
@endphp

<div class="card-deck">

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Prodotti non acquistabili</h5>
            <p class="card-text">
                Clicca sul nome di una categoria per vederne tutti i prodotti non raggiungibili dai clienti
            </p>
            <ul class="list-group list-group-flush">
                @foreach ($categories as $cat)
                <a href="{{ route('CategoryNotAvailablePage',$cat) }}">
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>{{ $cat->name }}</span>
                        <span class="badge badge-pill badge-dark">
                            {{ $cat->products()->notAvailable()->count() }}
                        </span>
                    </li>
                </a>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Inserimento prodotti</h5>
            <p class="card-text">Aggiungi un nuovo prodotto al catalogo di Zonko Shop</p>
            <a href="{{ action('ProductsController@create') }}">
                <span>Vai</span>
                <span><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Rifornimento prodotti</h5>
            <p class="card-text">Qui puoi vedere i prodotti che stanno per esaurirsi e aumentarne la disponibilità</p>
            <a href="{{ action('StoreController@showRefill') }}">
                <span>Vai</span>
                <span><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>

</div>

@endsection
