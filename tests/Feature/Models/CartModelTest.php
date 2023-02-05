<?php

namespace Tests\Feature\Models;

use App\Models\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CartModelTest extends TestCase
{
    use DatabaseMigrations;

    public function testShow()
    {
        Cart::factory(1)->create();
        $carts = Cart::all();

        $this->assertCount(1, $carts);

        $cartKeys = array_keys($carts->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'created_at',
            'id',
            'updated_at'
        ], $cartKeys);
    }

    public function testCreate()
    {
        $cart = Cart::create();
        $cart->refresh();

        $this->assertEquals(36, strlen($cart->id));
    }

    public function testDelete() {
        $cart = Cart::factory()->create();
        $cart->delete();
        $this->assertNull(Cart::find($cart->id));
    }
}
