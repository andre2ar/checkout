<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $appends = ['total'];

    public $incrementing = false;

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products->reduce(function ($carry, $product) {
                $carry += $product->item_total * $product->pivot->quantity;
                return $carry;
            }, 0),
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }
}
