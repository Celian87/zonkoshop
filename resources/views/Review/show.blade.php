@extends('layouts.app')

@section('title')
    Recensione di {{ $review->user->name }} per {{ $review->product->name }} - {{ config('app.name', 'ZonkoShop') }}
@endsection

@section('content')
<div class="col-md-12">
    <div class="h2">
        Recensione di {{ $review->user->name }} per {{ $review->product->name }}
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>{{ $review->user->name }}</span>
            <span>Pubblicata {{ $review->updated_at->diffForHumans() }}</span>
        </div>
        <div class="card-body">
            <h6>{!! nl2br(e($review->content)) !!}</h6>
        </div>
    </div>
</div>
@endsection
