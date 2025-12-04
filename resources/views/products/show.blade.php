@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="{{ asset('images/' . ($product->image ?? 'placeholder.png')) }}" class="img-fluid rounded" alt="{{ $product->name }}">
    </div>
    <div class="col-md-6">
        <h1>{{ $product->name }}</h1>
        <h3 class="text-success">₱{{ number_format($product->price, 2) }}</h3>
        <p>{{ $product->description }}</p>
        
        <button id="pay-button" class="btn btn-success btn-lg">Pay Now</button>
        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-warning btn-lg">Add to Cart</a>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById("pay-button").onclick = async function() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    try {
        const resp = await fetch("/paymongo/create-checkout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                amount: {{ $product->price }},
                name: "{{ $product->name }}",
                description: "{{ $product->description }}"
            })
        });

        const data = await resp.json();
        console.log('PayMongo checkout session response:', data);

        if (data.data && data.data.attributes && data.data.attributes.checkout_url) {
            const url = data.data.attributes.checkout_url;
            window.location.href = url;
        } else {
            console.error("Invalid checkout session response:", data);
            alert("Payment initialization failed — check console.");
        }
    } catch (err) {
        console.error("Error:", err);
        alert("An error occurred — see console for details.");
    }
};
</script>
@endsection
