@extends('layouts.app')

@section('title', 'Products')

@section('content')
<h1 class="mb-4">Products</h1>
<div class="row">
    @foreach ($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card product-card shadow-sm">
            <img src="{{ asset('images/' . ($product->image ?? 'placeholder.png')) }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">₱{{ number_format($product->price, 2) }}</p>
                <a href="/product/{{ $product->id }}" class="btn btn-primary w-100">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
