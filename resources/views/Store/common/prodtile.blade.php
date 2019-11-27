{{-- Tile di un prodotto, da includere con @include
    Genera UNA mattonella per ogni nuovo prodotto
    --}}
<div class="col-md-3">
    <div class="card w-50">
        <div class="card-img-top">
            <a href="{{ route('ShowProduct', $product->id) }}">
                <img class="card-img-top" src="{{ asset('images/prod/'.$product->imagepath) }}" alt="{{ $product->name }}">
            </a>
        </div>

        <div class="card-body">
            <a href="{{ route('ShowProduct', $product->id) }}">
                <h5 class="card-title" href="{{ route('ShowProduct', $product->id) }}">
                    {{ $product->name }}
                </h5>
            </a>
            <br>
            <h4 class="card-text">
                {{-- {!! nl2br(e($product->description)) !!} --}}
                <span>@currency($product->price)</span>
                <span><i class="fas fa-coins"></i></span>
            </h4>

        </div>

        <div class="card-footer">
            @if (Auth::check())
                @if ($product->isDisabled())
                <div>
                    <a class="btn btn-dark text-white">
                        <span>
                            <i class="fas fa-eye-slash"></i>
                        </span>
                        <span>Non acquistabile</span>
                    </a>
                </div>
                @else
                    @if($product->quantity == 0)
                    <div class="btn btn-grey text-danger" data-prod="{{ $product->id }}" id="product_{{ $product->id }}">
                        <span>
                            <i class="fas fa-clock"></i>
                        </span>
                        <span>ESAURITO</span>
                    </div>

                    @else {{-- Mostra i pulsanti d'acquisto solo se il prodotto è disponibile e l'utente non è admin --}}
                        @if(Auth::user()->isAdmin() == false)
                        <div id="comprato_{{ $product->id}}" @if($product->cart()->count() == 0) style="display: none;" @endif>
                            <a class="btn btn-disabled" href="{{action('CartController@index')}}">
                                <span>
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <span>Nel carrello</span>
                            </a>
                        </div>
                        <div id="disponibile_{{ $product->id}}" @if($product->cart()->count() > 0) style="display: none;" @endif>
                            <a
                                class="btn btn-warning add-to-cart"
                                href="{{ action('CartController@store') }}"
                                data-prod="{{ $product->id }}" id="product_{{ $product->id }}">
                                <span>
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <span>Aggiungi</span>
                            </a>
                        </div>
                        @else
                        <div class="btn btn-grey add-to-cart">
                            ID prodotto: {{ $product->id }}
                        </div>
                        @endif
                    @endif
                @endif
            @else
                <span>Accedi per acquistare</span>
            @endif
        </div>
    </div>
</div>

