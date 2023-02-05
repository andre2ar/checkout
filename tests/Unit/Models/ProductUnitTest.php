<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class ProductUnitTest extends TestCase
{
    private Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function testFillableAttributes()
    {
        $fillable = [
            'name',
            'price',
            'picture_url'
        ];

        $this->assertEquals($fillable, $this->product->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [
            HasFactory::class,
            HasUuids::class,
            SoftDeletes::class,
        ];
        $productTraits = array_keys(class_uses(Product::class));
        $this->assertEquals($traits, $productTraits);
    }

    public function testCastsAttribute()
    {
        $casts = [
            'price' => 'float',
            'deleted_at' => 'datetime'
        ];

        $this->assertEquals($casts, $this->product->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->product->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = [
            'deleted_at',
            'created_at',
            'updated_at'
        ];

        $categoryDates = $this->product->getDates();
        foreach ($dates as $date) {
            $this->assertContains($date, $categoryDates);
        }

        $this->assertCount(count($dates), $categoryDates);
    }
}
