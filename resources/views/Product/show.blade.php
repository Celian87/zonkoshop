{{-- Elenco informazioni sul SINGOLO prodotto --}}

@extends('layouts.app')

@section('title')
    {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@php
    $isAdmin = Auth::check() && Auth::user()->isAdmin();
@endphp


@section('content')
    {{-- Mostra tutte le info sul prodotto qui --}}
    <div class="col-md-12">
    @if($product->isDisabled() && $isAdmin)
        <div class="alert alert-dark" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="alert-heading">Prodotto disattivato</h4>
            <p>Questo prodotto è presente nel catalogo ma i clienti non possono vederlo o acquistarlo.</br>Il suo nome sarà sempre visibile nei dettagli degli ordini che lo contengono.</p>
            <hr>
            <a class="btn btn-dark disable-purchase"
                href="{{ action('CartController@destroy',$product) }}" data-id="{{ $product->id }}">
                <span><i class="fas fa-eye-slash"></i></span>
                <span>Riattiva acquisto</span>
            </a>
        </div>
    @endif
    <table class="prodotto_descr"><tr>
        <div class="col-md-4">
            <td style="padding: 10; padding-right:60">
                <img class="zoom" src="{{ asset('images/prod/'.$product->imagepath) }}" style="width:300px; height:300px;" align:center>
            </td>
        </div>

        <div class="col-md-8">
        <td style="padding-top:20; vertical-align: top">
            <table class="table">
            <tr><p class="titolo"><b>{{ $product->name }}</b></p></tr>
            <div class="row">
                @if($product->quantity < 1)
                <span>
                <h4>
                    <span class="badge badge-danger product-outofstock">
                        <span><i class="fas fa-clock"></i></span>
                        <span style="font-weight: bold">ESAURITO</span>
                    </span>
                </h4>
                </span>
                @endif

                @if($product->isDisabled())
                <span>
                    <h4>
                        <span class="badge badge-dark product-disabled">
                            <span><i class="fas fa-eye-slash"></i></span>
                            <span style="font-weight: bold">Non acquistabile</span>
                        </span>
                    </h4>
                </span>
                @endif
            </div>
            <tr><p><span style="font-weight: bold">Prezzo: </span><span>@currency($product->price) </span><span><i class="fas fa-coins"></i></span></tr>
            <tr>
                @if($product->quantity > 0)
                <p>Sono ancora disponibili {{$product->quantity}} unità di questo oggetto</p>
                @endif
            </tr>
            <tr>
                <h6 style="font-weight: bold">Descrizione:</h6>
                <p class="prodotto_descr">{!! nl2br(e($product->description)) !!}</p>
            </tr>
            <tr><td>
            {{--@if($isAdmin)--}}
                <form action="{{ action('CartController@store') }}" method="POST" style="font-weight: bold">
                    @csrf()

                    @if($product->quantity < 1 || $product->isDisabled())
                        <p id="product-not-available-text">Questo oggetto non è attualmente disponibile</p>
                    @else
                        @if ( $isAdmin )

                        @else
                            <input type="text" name="product_id" value={{ $product->id }}  style=display:none></br>
                            Quantità
                            <select name="quantity">
                            @php
                                $item = $product->cart;
                                $item_in_cart = Auth::check() && !$item->isEmpty();
                            @endphp
                            @for ($i=1; $i<=$product->quantity; $i++)

                                @if($item_in_cart && $item[0]->quantity == $i)
                                    <option value="{{$i}}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{$i}}">{{ $i }}</option>
                                @endif

                            @endfor
                        @endif
                    @endif

                    </select>

                    {{-- @if($item_in_cart)
                        <a class="btn cart-edit-quantity" href="{{action('CartController@update')}}">
                            Modifica quantità
                        </a>
                    @endif --}}

                    @if (Auth::check())
                        @if ( !Auth::user()->isAdmin() )
                            @if ($product->cart()->count() > 0)
                            <a class="btn btn-disabled" href="{{action('CartController@index')}}">
                                <span><i class="fas fa-shopping-cart"></i></span>
                                <span>Nel carrello</span>
                            </a>
                            @else
                            @if($product->quantity > 0)
                            <button class="btn btn-warning add-to-cart" type="submit">
                                <span>
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <span>Aggiungi al Carrello</span>
                            </a>
                            @endif
                            @endif
                        @else
                            <br>
                            <span>
                                <a class="btn btn-dark" href="{{ action('ProductsController@edit', $product->id) }}">
                                    <span><i class="fas fa-edit"></i></span>
                                    <span>Modifica dettagli prodotto</span>
                                </a>
                            </span>
                        @endif
                    @else
                        <p>
                            <div>Accedi col tuo account per acquistare</div>
                        </p>
                    @endif
                </form>
            </td></tr>
            </table>
        </td>
        </div>
    </table>

    <br>
    <h3 style="font-weight: bold">Recensioni degli Utenti</h3>
    <div class="list-group">
        @forelse ($product->reviews as $review)
            <div class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div class="h5 mb-1">
                        <span class="h4">
                            {{ $review->user->name }}

                            @if (Auth::check() && $review->user->id == Auth::user()->id)
                            <span>
                                <a class="btn small" href="{{ action('ReviewController@edit',$review->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </span>
                            @endif
                        </span>
                    </div>
                    <small class="text-muted" style="margin-left: 10px;">
                        Pubblicata {{ $review->updated_at->diffForHumans() }}
                    </small>
                </div>
                @if($isAdmin)
                <div class="justify-content-end d-flex w-100">
                    <form action="{{ action('ReviewController@destroy',$review->id) }}" method="post">
                        @method('DELETE')
                        @csrf()
                        <button class="btn btn-dark" type="submit">
                            <span><i class="fas fa-radiation"></i></span>
                            <span>[ CENSURA ]</span>
                        </button>
                    </form>
                </div>
                @endif
                <br>
                <div>
                    <h6>{!! nl2br(e($review->content)) !!}</h6>
                </div>
            </div>
            </br>
        @empty
            <div>
                <p>Non ci sono ancora recensioni per questo prodotto. </br>Fai sapere a tutti che cosa ne pensi lasciandone una per primo!
                </p>
            </div>
        @endforelse

        {{-- <form action="{{ action('ReviewController@create',$product->id) }}" method="GET">
            <input type="text" hidden name="product_id" value="{{ $product->id}}">
            <button type="submit" class="btn btn-success">Scrivi una recensione</button>
        </form> --}}
    </div>
    @if (Auth::check())
    <div>
        <a class="btn btn-primary" href="{{ action('ReviewController@create') }}?product_id={{ $product->id }}">
            Scrivi una recensione
        </a>
    </div>
    @endif
    </div>

@endsection

@if($isAdmin)
    @section('page-javascript')
    <script>
    $(document).ready( (event) => {
        $('.disable-purchase').on('click', (event) => {
            event.preventDefault();

            $.ajax({
                method: 'PATCH',
                dataType: "json",
                url: $(this).attr('href'),
                data: {
                    //_token: document.getElementsByName("_token")[0].value, //CSRF
                    product_id: $(this).attr('data-id')
                },
                success: function(response){
                    console.log(response);
                    $(".alert").alert('close');
                    $(".badge.product-disabled").remove();

                    if ($(".badge.product-outofstock").length == 0) { //non nascondere il testo "non disponibile" se il prodotto è esaurito!
                        $("#product-not-available-text").remove();
                    }

                },
                error: function(request, error) {
                    console.log("AJAX error "+request.status+": "+request.statusText);
                }
            });
        });
    });
    </script>
    @append
@endif
