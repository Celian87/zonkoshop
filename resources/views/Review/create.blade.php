@extends('layouts.app')

@section('title')
    Nuova recensione per {{ $product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection


@section('content')
<div class="col-md-12">
    <h2 style="color: blue">Scrivi una recensione</h2>

    <form method="POST" action="{{ action('ReviewController@store') }}">
        @csrf

        <input type="number" name="product_id" value="{{ $product->id }}" hidden>

        <div>
            <label for="content">Stai scrivendo una recensione per <b>{{ $product->name }}</b></label>
            <div class="">
                <textarea name="content" id="content" rows="10"
                    class="form-control {{ $errors->has('content') ? 'is-invalid' : ''}} ">{{ old('content') }}
                </textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col" style="padding-top: 10px">
                <button type="submit" class="btn btn-success">
                    <span><i class="fas fa-globe"></i></span>
                    <span>Pubblica</span>
                </button>
            </div>
        </div>

    </form>
</div>
@endsection
