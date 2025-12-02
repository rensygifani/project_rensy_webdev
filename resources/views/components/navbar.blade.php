<nav class="navbar pastel-navbar shadow-sm py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('products') }}">
            <div class="brand-badge">✿</div>
            <div>
                <div class="fw-bold pastel-brand" style="font-size:18px;">Rensy Gallery</div>
                <div class="small text-muted" style="font-size:12px;">Bouquet • Frame • Scrapframe</div>
            </div>
        </a>

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('products.create') }}" class="btn pastel-btn">
                + Add Product
            </a>
        </div>
    </div>
</nav>
