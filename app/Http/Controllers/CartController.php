<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $cart = new Cart();
        $cart->save();

        return $cart;
    }

    public function show($id)
    {
        return Cart::with('products')->findOrFail($id);
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->noContent();
    }
}
