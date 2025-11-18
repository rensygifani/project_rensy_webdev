@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="mb-4">
        <h2 class="fw-bold">Product Detail</h2>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="placeholder-image d-flex justify-content-center align-items-center">
                    <span class="text-muted fw-bold" style="font-size: 20px;">
                        {{ $product['id'] }}
                    </span>
                </div>
            </div>

            <div class="col-md-8">
                <h4 class="fw-bold mb-2">{{ $product['name'] }}</h4>

                <p class="text-secondary" style="font-size: 15px;">
                    {{ $product['description'] }}
                </p>

                <h3 class="fw-bold text-danger mt-3">
                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                </h3>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('products') }}" class="btn btn-secondary px-4">Back</a>

                    <a href="{{ route('products.edit', $product['id']) }}"
                       class="btn btn-warning px-4 text-white">
                       Edit Product
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
.placeholder-image {
    width: 100%;
    height: 250px;
    background: #f2f2f2;
    border-radius: 12px;
    border: 1px solid #e5e5e5;
}
</style>

@endsection
