<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PHPUnit\Framework\TestCase;

class CartUnitTest extends TestCase
{
    private Cart $cart;
    protected function setUp(): void
    {
        parent::setUp();
        $this->cart = new Cart();
    }

    public function testFillableAttributes()
    {
        $this->assertEquals([], $this->cart->getFillable());
    }

    public function testIfUseTraits()
    {
        $traits = [
            HasFactory::class,
            HasUuids::class,
        ];
        $productTraits = array_keys(class_uses(Cart::class));
        $this->assertEquals($traits, $productTraits);
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->cart->incrementing);
    }

    public function testDatesAttribute()
    {
        $dates = [
            'created_at',
            'updated_at'
        ];

        $categoryDates = $this->cart->getDates();
        foreach ($dates as $date) {
            $this->assertContains($date, $categoryDates);
        }

        $this->assertCount(count($dates), $categoryDates);
    }
}
