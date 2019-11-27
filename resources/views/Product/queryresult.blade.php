{{-- Visualizza tutti i prodotti passati--}}

@extends('layouts.app')

@section('title')
    {{ $tabname }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="container">
    <h3 style="padding: 15px">{{ $title }}</h3>

        <div class="card-deck">

            @foreach ($prodlist as $product)
                 @include('Store.common.prodtile', ['product' => $product])
            @endforeach


        </div>


    {{-- mostra una tile per ogni prodotto --}}
    {{--@forelse ($prodlist as $product)
        <span class="list-item">
            @include('Store.common.prodtile', ['product' => $product])
        </span>

    @empty
    <p class="text">Al momento non ci sono prodotti disponibili in questa categoria</p>
    @endforelse--}}



</div>
@endsection

@section('page-javascript')
<script>
$("document").ready(function () {
    $(".add-to-cart").bind("click", function(event) { //non funzia se si imposta con onclick nell'HTML
        event.preventDefault(); //evita che la pagina cambi

        var product = $(this).attr("data-prod");
        //console.log($(this).parent().attr('action'));

        addToCart("{{ action('CartController@store') }}", product);
    });
});
</script>
@endsection
