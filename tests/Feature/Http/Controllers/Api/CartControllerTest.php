<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestResources;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class CartControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves, TestResources;
    private Cart $cart;
    private array $serializedFields = [
        'id',
        'updated_at',
        'created_at',
        'gross_total',
        'products'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = Cart::factory()->create();
    }

    public function testShow()
    {
        $response = $this->get(route('carts.show', ['cart' => $this->cart->id]));
        $response->assertStatus(200)
            ->assertJsonStructure($this->serializedFields)
            ->assertJson($this->cart->toArray());
    }

    public function testStore()
    {
        $response = $this->assertStore([], []);
        $response->assertJsonStructure($this->serializedFields);
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE', route('carts.destroy', [
            'cart' => $this->cart->id,
        ]));
        $response->assertStatus(204);
        $this->assertNull(Cart::find($this->cart->id));
    }

    protected function routeStore()
    {
        return route('carts.store');
    }

    protected function routeUpdate()
    {
        return route('carts.update', ['cart' => $this->cart->id]);
    }

    protected function model()
    {
        return Cart::class;
    }
}
