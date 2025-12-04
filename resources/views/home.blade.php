@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero Section --}}
<div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Welcome to Our Store</h1>
        <p class="col-md-8 fs-5">
            Discover high-quality products with fast service and secure payment options.
        </p>
        <a href="/products" class="btn btn-primary btn-lg">Shop Now</a>
    </div>
</div>

{{-- Features Section --}}
<div class="row text-center mb-5">
    <div class="col-md-4">
        <h1>⚡</h1>
        <h4>Fast & Reliable</h4>
        <p class="text-muted">Optimized performance for a smooth shopping experience.</p>
    </div>

    <div class="col-md-4">
        <h1>🔒</h1>
        <h4>Secure Payments</h4>
        <p class="text-muted">PayMongo, Paynamics, GCash, and more supported.</p>
    </div>

    <div class="col-md-4">
        <h1>⭐</h1>
        <h4>Top Quality</h4>
        <p class="text-muted">We offer only the best products for our customers.</p>
    </div>
</div>

{{-- Featured Products Section --}}
<h2 class="mb-4">Featured Products</h2>

<div class="row">
    @foreach ($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card product-card shadow-sm">
            <img src="{{ asset('images/' . ($product->image ?? 'placeholder.png')) }}"
                 class="card-img-top"
                 alt="{{ $product->name }}">

            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">₱{{ number_format($product->price, 2) }}</p>

                <a href="/product/{{ $product->id }}" class="btn btn-primary w-100">
                    View Details
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
