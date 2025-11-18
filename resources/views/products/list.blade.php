@extends('layouts.app')

@section('content')
<div class="container mt-3">

    <h3 class="mb-4 fw-bold">Product List</h3>

    <div class="row g-3">
        @foreach ($products as $product)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card border-0 shadow-sm p-3 list-card" style="cursor:pointer;">

                <div class="product-box text-center">
                    <div class="placeholder-box mb-2">
                        {{ $product['id'] }}
                    </div>

                    <h6 class="text-dark">{{ $product['name'] }}</h6>

                    <p class="text-muted small" style="height:35px; overflow:hidden;">
                        {{ $product['description'] }}
                    </p>

                    <p class="m-0 fw-bold text-danger" style="font-size: 15px;">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </p>

                    <div class="mt-2 d-flex gap-1">
                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-outline-primary btn-sm w-50">Show</a>
                        <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-outline-warning btn-sm w-50">Edit</a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>

<style>
    .list-card {
        transition: 0.2s;
        border-radius: 10px;
    }
    .list-card:hover {
        transform: translateY(-5px);
        box-shadow: 1px 6px 15px rgba(0,0,0,0.15);
    }
    .placeholder-box {
        width: 100%;
        height: 120px;
        background: #f2f2f2;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        color: #999;
        font-size: 18px;
    }
</style>

@endsection
