<?php

namespace App\Http\Controllers;

use App\Exceptions\ResourceNotFound;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ItemsController extends Controller
{
    public function index(Cart $cart)
    {
        return $cart->products;
    }

    public function store(StoreItemRequest $request, Cart $cart)
    {
        $validated = $request->validated();

        $item = DB::table('cart_product')->where([
            'cart_id' => $cart->id,
            'product_id' => $validated['product_id']
        ])->first();

        if($item) {
            $cart->products()->updateExistingPivot($validated['product_id'], [
                'quantity' => $item->quantity + $validated['quantity']
            ]);
        } else {
            $cart->products()->syncWithoutDetaching([
                $validated['product_id'] => [
                    'id' => Uuid::uuid4(),
                    'quantity' => $validated['quantity']
                ]
            ]);
        }

        return $cart->load('products');
    }

    public function update(UpdateItemRequest $request, Cart $cart, $productId)
    {
        $validated = $request->validated();

        $item = DB::table('cart_product')->where([
            'cart_id' => $cart->id,
            'product_id' => $productId
        ])->first();

        if($item) {
            $cart->products()->updateExistingPivot($productId, [
                'quantity' => $validated['quantity']
            ]);
        }

        return $cart->load('products');
    }

    public function destroy(Cart $cart, $id)
    {
        $item = DB::table('cart_product')->where([
            'cart_id' => $cart->id,
            'product_id' => $id
        ])->delete();

        if(!$item) {
            throw new ResourceNotFound('Item');
        }

        return response()->noContent();
    }
}
