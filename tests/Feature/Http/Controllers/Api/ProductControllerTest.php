<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestResources;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;

class ProductControllerTest extends TestCase
{
    use DatabaseMigrations, TestValidations, TestSaves, TestResources;
    private Product $product;
    private array $serializedFields = [
        'name',
        'price',
        'picture_url'
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200)
            ->assertJson([
                'per_page' => 15
            ])
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->serializedFields
                ],
                'links' => [],
            ]);

        $resource = ProductResource::collection([$this->product]);
        $this->assertResource($response, $resource);
    }

    public function testShow()
    {
        $response = $this->get(route('products.show', ['product' => $this->product->id]));
        $response->assertStatus(200)
            ->assertJsonStructure($this->serializedFields)
            ->assertJson($this->product->toArray());
    }

    public function testInvalidationData()
    {
        $data = [
            'name' => '',
            'price' => null
        ];
        $this->assertInvalidationInStoreAction($data, 'required');
        $this->assertInvalidationInUpdateAction(['price' => null], 'decimal', ['decimal' => '0-3']);

        $data = [
            'name' => str_repeat('a', 256),
        ];
        $this->assertInvalidationInStoreAction($data, 'max.string', ['max' => 255]);
        $this->assertInvalidationInUpdateAction($data, 'max.string', ['max' => 255]);
    }

    public function testStore()
    {
        $data = [
            "name" => "Product",
            "price" => 10,
        ];
        $response = $this->assertStore($data, $data);
        $response->assertJsonStructure($this->serializedFields);
    }

    public function testUpdate() {
        $data = [
            "name" => "Product",
            "price" => 10
        ];
        $response = $this->assertUpdate($data, $data);
        $response->assertJsonStructure($this->serializedFields);

        $data = [
            "name" => "Product 2",
            "price" => 10,
        ];
        $this->assertUpdate($data, $data);
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE', route('products.destroy', [
            'product' => $this->product->id,
        ]));
        $response->assertStatus(204);
        $this->assertNull(Product::find($this->product->id));
    }

    protected function routeStore()
    {
        return route('products.store');
    }

    protected function routeUpdate()
    {
        return route('products.update', ['product' => $this->product->id]);
    }

    protected function model()
    {
        return Product::class;
    }
}
