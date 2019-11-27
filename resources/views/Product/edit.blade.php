@extends('layouts.app')

@section('title')
    Modifica {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Modifica dettagli Prodotto</h1>

        <form method="POST" action="{{ action('ProductsController@update', $product->id) }}">
            @method('PATCH')
            @csrf()

            <div class="form-group">
                <label for="name">Nome</label>
                <div>
                    <input type="text" class="form-control form-control-lg" name="name" value="{{ $product->name }}">
                </div>
            </div>

            <div class="form-group">
                <label for="name">Immagine</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">/images/prod/</div>
                    </div>
                    <input type="text" class="form-control form-control" name="imagepath" value="{{ $product->imagepath }}">
                </div>
            </div>

            <div class="form-group row">
                <div class="col">
                    <label for="price">Prezzo</label>
                    <div>
                        <div class="input-group mb-2">
                                <input type="number" min="0" step="0.01" class="form-control" name="price" value="{{ $product->price }}">
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fas fa-coins"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <label for="quantity">Quantità</label>
                    <input type="number" min="0" class="form-control" name="quantity" value="{{ $product->quantity }}">
                </div>
            </div>

            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select class="form-control" name="category_id" id="category_id">
                    @foreach (App\Category::all() as $category)
                        @if ( old('category_id') == $category->id || $category->id == $product->category_id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}" >{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div>
                    <label>Disponibile per l'acquisto</label>
                </div>
                @if ($product->isDisabled())
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="form-check-input" type="radio" name="is_disabled" value="0">
                        <label class="form-check-label" for="inlineRadio1">Disponibile</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="form-check-input" type="radio" name="is_disabled" value="1" checked>
                        <label class="form-check-label">Non Disponibile</label>
                    </div>
                    @else
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="form-check-input" type="radio" name="is_disabled" value="0" checked>
                        <label class="form-check-label">Disponibile</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input class="form-check-input" type="radio" name="is_disabled" value="1">
                        <label class="form-check-label">Non disponibile</label>
                    </div>
                    @endif
            </div>
            <div class="form-group">
                <label for="content" class="form-field">Descrizione</label>
                <div>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ $product->description }}</textarea>
                </div>
            </div>
            <div class="form-group form-group-inline">
                <button type="submit" class="btn btn-primary">Aggiorna dettagli</button>
                <a href="." class="btn btn-light btn-grey">Annulla</a>
            </div>

        </form>
    </div>
</div>
@endsection
