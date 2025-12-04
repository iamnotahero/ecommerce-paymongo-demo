@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<h1 class="mb-4">Shopping Cart</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(count($cart) > 0)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($cart as $id => $item)
            @php $subtotal = $item['price'] * $item['quantity']; @endphp
            <tr>
                <td>
                    <img src="{{ asset('images/' . ($item['image'] ?? 'placeholder.png')) }}" width="50" class="me-2">
                    {{ $item['name'] }}
                </td>
                <td>₱{{ number_format($item['price'], 2) }}</td>
                <td>
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control d-inline w-50">
                        <button class="btn btn-sm btn-primary">Update</button>
                    </form>
                </td>
                <td>₱{{ number_format($subtotal, 2) }}</td>
                <td>
                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-sm btn-danger">Remove</a>
                </td>
            </tr>
            @php $total += $subtotal; @endphp
        @endforeach
    </tbody>
</table>

<h3>Total: ₱{{ number_format($total, 2) }}</h3>

<!-- Checkout button -->
<form id="checkout-form" method="POST">
    @csrf
    <button type="button" id="checkout-button" class="btn btn-success btn-lg">Checkout with PayMongo</button>
</form>

@else
<p>Your cart is empty. <a href="/">Go shopping!</a></p>
@endif
@endsection

@section('scripts')
<script>
document.getElementById("checkout-button").onclick = async function() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Prepare cart items
    const cartItems = @json($cart);

    // Calculate total amount
    let totalAmount = 0;
    for (const id in cartItems) {
        totalAmount += cartItems[id].price * cartItems[id].quantity;
    }

    try {
        const resp = await fetch("/paymongo/create-checkout", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
                "Accept": "application/json"
            },
            body: JSON.stringify({
                amount: totalAmount,
                name: "Cart Checkout",
                description: "Purchase of multiple products"
            })
        });

        const data = await resp.json();
        if (data.data && data.data.attributes && data.data.attributes.checkout_url) {
            window.location.href = data.data.attributes.checkout_url;
        } else {
            console.error("Invalid checkout session:", data);
            alert("Failed to create checkout session.");
        }
    } catch(err) {
        console.error(err);
        alert("Error during checkout.");
    }
};
</script>
@endsection
