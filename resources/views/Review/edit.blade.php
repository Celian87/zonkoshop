@extends('layouts.app')

@section('title')
    Modifica recensione per {{ $review->product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="col-md-12">
    <h1>Modifica recensione</h1>


        <form method="POST" action="{{ action('ReviewController@update',$review) }}">
            @csrf()

            <input type="number" name="product_id" value="{{ $review->product_id }}" hidden>

            <div class="form-group">
                <label for="content">
                    La tua recensione per
                    <a href="{{ action('ProductsController@show',$review->product->id) }}">
                        {{ $review->product->name }}
                    </a>
                </label>
                <div>
                    <textarea name="content" id="content" rows="10"
                        class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}} ">{{ $review->content }}
                    </textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col">
                    <button name="_method" value="PATCH" type="submit" class="btn btn-success">
                        <span><i class="fas fa-globe"></i></span>
                        <span>Pubblica modifiche</span>
                    </button>
                </div>
                <div class="col">
                    <a href="{{ action('ProductsController@show',$review->product) }}" class="btn btn-light">Torna al prodotto</a>
                </div>
                <div class="col">
                    <button name="_method" value="DELETE" class="btn btn-danger" type="submit" onclick="return confirm('Sei sicuro di voler ELIMINARE QUESTA RECENSIONE?\n\nQuesta azione non può essere annullata')">
                        <span><i class="fas fa-trash"></i></span>
                        <span>ELIMINA RECENSIONE</span>
                    </button>
                </div>
            </div>

        </form>


        <div class="field is-grouped">
            <form method="POST" action="{{ action('ReviewController@destroy',$review->id) }}">
                @method('DELETE')
                @csrf()
            </form>
        </div>
    </span>
</div>
@endsection
