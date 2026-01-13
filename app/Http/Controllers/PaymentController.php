<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function createSnapToken(Request $request)
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = false; // sandbox
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => 'RG-' . time(),
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email'      => $request->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }

    // callback dari Midtrans (wajib ada)
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signature = hash(
            "sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($signature !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // nanti di sini update status order ke database
        // settlement / pending / expire / cancel

        return response()->json(['message' => 'OK']);
    }
}
