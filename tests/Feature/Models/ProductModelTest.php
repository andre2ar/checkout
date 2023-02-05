<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        Product::factory(1)->create();
        $products = Product::all();

        $this->assertCount(1, $products);

        $productKeys = array_keys($products->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'created_at',
            'deleted_at',
            'id',
            'name',
            'picture_url',
            'price',
            'updated_at'
        ], $productKeys);
    }

    public function testCreate()
    {
        $product = Product::create([
            "name" => "Product",
            "price" => 10,
        ]);
        $product->refresh();

        $this->assertEquals(36, strlen($product->id));
        $this->assertEquals('Product', $product->name);
        $this->assertEquals(10, $product->price);
        $this->assertEquals(null, $product->picture_url);
        $this->assertEquals(null, $product->deleted_at);
    }

    public function testUpdate()
    {
        $office = Product::factory()->create([
            "name" => "Product",
            "price" => 10,
        ]);

        $data = [
            "name" => "Product_updated",
            "price" => 101,
        ];
        $office->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $office->{$key});
        }
    }

    public function testDelete() {
        $product = Product::factory()->create();
        $product->delete();
        $this->assertNull(Product::find($product->id));
    }
}
