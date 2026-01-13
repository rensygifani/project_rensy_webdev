<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('products');
});

/*
|--------------------------------------------------------------------------
| Product Routes (Public)
|--------------------------------------------------------------------------
*/
Route::controller(ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'index')->name('products');
        Route::get('/show/{id}', 'show')->name('products.show');
    });

/*
|--------------------------------------------------------------------------
| Dashboard (Breeze default)
|--------------------------------------------------------------------------
*/
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('products');
})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    // Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout');
    // Route::post('/checkout', [CheckoutController::class, 'form'])->name('checkout.preview');
    // Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Buy Now
    Route::post('/buy-now/{product}', [CheckoutController::class, 'buyNow'])
        ->name('buy.now')
        ->middleware('auth');


    // Route::post('/products/{product}/review', [ReviewController::class, 'store'])
    // ->middleware('auth')
    // ->name('review.store');

    Route::middleware('auth')->group(function () {
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])
        ->name('review.store');
});



    // Checkout
    Route::post('/checkout/preview', [CheckoutController::class, 'form'])
        ->name('checkout.preview');

    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');


    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // Product Management (optional, jika hanya admin)
    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/create', 'create')->name('products.create');
        Route::post('/products/store', 'store')->name('products.store');
        Route::get('/products/edit/{id}', 'edit')->name('products.edit');
        Route::put('/products/update/{id}', 'update')->name('products.update');
        Route::delete('/products/delete/{id}', 'destroy')->name('products.destroy');
    });


    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist');

    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');

    Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])
        ->name('wishlist.remove');


});

// Route::get('/', [App\Http\Controllers\RajaOngkirController::class, 'index']);

Route::get('/ongkir', [RajaOngkirController::class, 'index']);
Route::get('/cities/{province_id}', [RajaOngkirController::class, 'getCities']);
Route::get('/districts/{cityId}', [RajaOngkirController::class, 'getDistricts']);
Route::post('/check-ongkir', [RajaOngkirController::class, 'checkOngkir']);
// Route::post('/check-ongkir', [RajaOngkirController::class, 'checkOngkir']);


Route::middleware('auth')->group(function () {

    Route::get('/checkout/payment', function () {
        return view('checkout.payment');
    })->name('checkout.payment');

    Route::post('/midtrans/token', [PaymentController::class, 'createSnapToken'])
        ->name('midtrans.token');
});

Route::post('/midtrans/callback', [PaymentController::class, 'callback']);


/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
