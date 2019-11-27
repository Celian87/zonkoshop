{{-- Carrello dell'utente --}}

@extends('layouts.app')

@section('title')
Il tuo carrello - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="content">
                <ul class="list-group">
                    @if ($cart->count()==0)
                        <h2>Il tuo carrello è vuoto.</h2>
                        <p>Il tuo carrello è vuoto.
                            Per aggiungere articoli al tuo carrello naviga su ZonkoShop.test,
                            quando trovi un articolo che ti interessa, clicca su "Aggiungi".
                        </p>
                    @else
                        <h3>Il tuo carrello</h3>
                        @php
                            $totale = 0.0;
                        @endphp
                        @foreach ($cart as $item)
                        <div class="list-group-item cart-item" id="cart-{{ $item->id }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="mb-1">
                                    <a href="{{ action('ProductsController@show',$item->product->id) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </h4>

                                @php
                                    $item_price = $item->quantity * $item->product->price;
                                    $totale += $item_price;
                                @endphp
                                <span class="h5">
                                    <span id="item-{{ $item->id }}-price">@currency($item_price)</span>
                                    <span><i class="fas fa-coins"></i></span>
                                </span>
                            </div>
                            <br>
                            <div class="d-flex w-100 justify-content-between">
                                <span>
                                    <span>Quantità</span>
                                    <span>
                                        <select name="quantity"
                                        class="edit-quantity"
                                        route="{{ action('CartController@update',$item->id) }}"
                                        data-id="{{ $item->id }}"
                                        >
                                            @for ($i=1; $i <= ($item->product->quantity + $item->quantity); $i++)
                                                <option value="{{ $i }}"
                                                @if($item->quantity == $i)
                                                    selected
                                                @endif
                                                >{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </span>
                                </span>

                                <span>
                                    <a
                                     class="btn btn-danger remove-from-cart"
                                     href="{{ action('CartController@destroy',$item->id) }}"
                                     data-id={{ $item->id }}
                                    >
                                        <span><i class="fas fa-trash"></i></span>
                                        <span>Rimuovi</span>
                                    </a>
                                </span>
                            </div>
                        </div>
                        @endforeach

                        <hr>
                        <div class="d-flex w-100 justify-content-between">
                            <div class="h3">Totale</div>
                            <h3>
                                <span id="totale">@currency($totale)</span>
                                <span><i class="fas fa-coins"></i></span>
                            </h3>
                        </div>

                        <div class="justify-content-end d-flex">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#confirmPurchaseModal">
                                Procedi con l'acquisto
                            </button>
                        </div>

                    @endif

                </ul>
            </div>
        </div>
    </div>

    @if($cart->count() > 0)
    <!-- Modal -->
    <div class="modal fade" id="confirmPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Conferma acquisto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Sei sicuro di voler procedere?</br></br>
              Al momento hai @currency(Auth::user()->money) <i class="fas fa-coins"></i>,
              dopo l'acquisto ti resteranno
              <span id="confirmTotale">
                  @currency(Auth::user()->money - $totale)
              </span>
              <i class="fas fa-coins"></i>.
              <div id="missing-money-warning" class="text-danger"
                @if($totale <= Auth::user()->money) style="display: none;" @endif
                >
                <br>
                Non hai abbastanza <span><i class="fas fa-coins"></i></span> per completare l'acquisto
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-dismiss="modal">Annulla e torna al carrello</button>
              <div class="justify-content-end d-flex">
                    <form action="{{ action('OrdersController@store') }}" method="post">
                        @csrf()
                        <button id="purchase" type="submit" class="btn btn-warning">
                            Completa acquisto
                        </button>
                    </form>
                </div>
            </div>
          </div>
        </div>
    </div>
    @endif
@endsection


@section('page-javascript')
<script>
var JSONresponse;

function updateSoldi(totale, nuovosaldo) {
    //Aggiorno il totale
    $("#totale").text(""+totale);
    $('#confirmTotale').text(''+nuovosaldo);

    //Avviso nella schermata di conferma
    if (parseFloat(nuovosaldo) < 0) {
        $('#missing-money-warning').show();
    }
    else $('#missing-money-warning').hide();
}

$(document).ready(function(){
    //ELIMINA DAL CARRELLO
    $(".remove-from-cart").bind("click", function(event) {
            event.preventDefault(); //evita che la pagina cambi
            var cart_id = $(this).attr('data-id');

            //richiesta AJAX
            $.ajax({
                method: 'DELETE',
                dataType: "json",
                url: $(this).attr('href'),
                data: {
                    //_token: document.getElementsByName("_token")[0].value, //CSRF
                    //product_id: product_id
                },
                success: function(response){
                    console.log(response); //stampa quello che ha restituito il controller

                    //Elimino riga dal DOM
                    $('#cart-'+cart_id).slideUp();

                    //Aggiorno i valori
                    updateSoldi(response.totale, response.nuovosaldo);

                    //Se era l'ultimo elemento, disattiva il pulsante per acquistare
                    if ($('.cart-item').length < 1) {
                        $('#purchase').prop("disabled",true);
                    }
                },
                error: function(request, error) {
                    console.log("AJAX error "+request.status+": "+request.statusText);
                    //console.log(request); console.log(error);
                }
            });
        });

    //CAMBIA QUANTITA'
    $(".edit-quantity").bind("change", function(){
        //console.log($(this));
        //$(this).css("background-color", "#D6D6FF");
        var cart_id = $(this).attr("data-id")

        //Preparo la richiesta
        var data = {
            //_token: document.getElementsByName("_token")[0].value, //CSRF
            //product_id: $(this).attr("data-prodid"),
            quantity: $(this).val()
        };

        //Richiesta AJAX
        $.ajax({
            method: 'PATCH',
            dataType: "json",
            url: $(this).attr('route'),
            data: data,
            success: function(response){
                //response = JSON.parse(response); //solo se non si usa datatype: "json"
                console.log(response); //stampa quello che ha restituito il controller

                //Aggiorno i valori a schermo
                $("#item-"+cart_id+"-price").text(""+response.newPrice);
                updateSoldi(response.totale, response.nuovosaldo);
            },
            error: function(request, error) {
                console.log("AJAX error "+request.status+": "+request.statusText);
                //console.log(request); console.log(error);
            }
        });
    });
});


</script>
@endsection
