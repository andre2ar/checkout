<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ItemsControllerTest extends TestCase
{
    use DatabaseMigrations;
    private Cart $cart;
    private Product $product;
    private array $serializedFields = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = Cart::factory()->create();
        $this->product = Product::factory()->create();
    }

    public function testStore()
    {
        $data = [
            'product_id' => $this->product->id,
            'quantity' => 1
        ];
        $response = $this->json('POST', route('carts.items.store', [
            'cart' => $this->cart,
            'item' => $this->product->id
        ]), $data);

        $response->assertStatus(200)
            ->assertJson([
                'total' => $this->product->item_total,
            ])->assertJsonIsObject();
        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $response->json('id'),
            'product_id' => $response->json('products.0.id'),
            'quantity' => 1
        ]);

        $response = $this->json('POST', route('carts.items.store', [
            'cart' => $this->cart,
            'item' => $this->product->id
        ]), $data);

        $response->assertStatus(200)
            ->assertJson([
                'total' => $this->product->item_total * 2,
            ])->assertJsonIsObject();
        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $response->json('id'),
            'product_id' => $response->json('products.0.id'),
            'quantity' => 2
        ]);
    }

    public function testUpdate()
    {
        $quantity = 5;
        $this->json('POST', route('carts.items.store', [
            'cart' => $this->cart,
            'item' => $this->product->id
        ]), [
            'product_id' => $this->product->id,
            'quantity' => 1
        ]);

        $response = $this->json('PUT', route('carts.items.update', [
            'cart' => $this->cart,
            'item' => $this->product->id
        ]), ['quantity' => $quantity]);

        $response->assertStatus(200)
            ->assertJson([
                'total' => $this->product->item_total * $quantity,
            ])->assertJsonIsObject();
        $this->assertDatabaseHas('cart_product', [
            'cart_id' => $response->json('id'),
            'product_id' => $response->json('products.0.id'),
            'quantity' => $quantity
        ]);
    }

    public function testDestroy()
    {
        $this->json('POST', route('carts.items.store', [
            'cart' => $this->cart,
            'item' => $this->product->id
        ]), [
            'product_id' => $this->product->id,
            'quantity' => 1
        ]);

        $response = $this->json('DELETE', route('carts.items.destroy', [
            'cart' => $this->cart->id,
            'item' => $this->product->id
        ]));
        $response->assertStatus(204);

        $item = DB::table('cart_product')->where([
            'cart_id' => $this->cart->id,
            'product_id' => $this->product->id
        ])->first();

        $this->assertNull($item);
    }
}
