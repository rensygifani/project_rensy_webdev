<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // ⬅️ WAJIB INI
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;


class CheckoutController extends Controller
{
    public function form(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())->firstOrFail();

        $items = $cart->items()
            ->whereIn('id', $request->items)
            ->with('product')
            ->get();

        $total = $items->sum(fn($i) => $i->product->price * $i->qty);

        // =====================
        // AMBIL DATA PROVINSI
        // =====================
        $response = Http::withHeaders([
            'key' => config('rajaongkir.api_key'),
            'Accept' => 'application/json'
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        $provinces = $response->successful()
            ? $response->json()['data']
            : [];

        return view('checkout.form', compact(
            'items',
            'total',
            'provinces'
        ));

        return view('checkout.form', compact('items', 'total'));
    }

    /**
     * Proses checkout
     */

    public function buyNow(Product $product)
    {
        $items = collect([
            (object)[
                'product' => $product,
                'qty' => 1
            ]
        ]);

        $total = $product->price;

        return view('checkout.form', [
            'items' => $items,
            'total' => $total,
            'mode' => 'buy_now',
            'product_id' => $product->id
        ]);
    }


    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'payment_method' => 'required',
        ]);

        // MODE BUY NOW
        if ($request->mode === 'buy_now') {

            $product = Product::findOrFail($request->product_id);

            $order = Order::create([
                'user_id' => auth()->id(),
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'total' => $product->price
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'qty' => 1,
                'price' => $product->price
            ]);

            return redirect()->route('orders')
                ->with('success', 'Pembelian berhasil (Buy Now)');
        }


        // MODE CART (kode lama kamu)
        $request->validate([
            'items' => 'required|array|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())->firstOrFail();

        $items = $cart->items()
            ->whereIn('id', $request->items)
            ->with('product')
            ->get();

        $total = $items->sum(fn($i) => $i->product->price * $i->qty);

        $order = Order::create([
            'user_id' => auth()->id(),
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'total' => $total
        ]);

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->product->price
            ]);
        }

        $cart->items()->whereIn('id', $request->items)->delete();

        return redirect()->route('orders')
            ->with('success', 'Checkout berhasil');
    }
}
