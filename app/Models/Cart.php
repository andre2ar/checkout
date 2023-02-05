<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasUuids;

    protected $appends = ['gross_total', 'net_total', 'vat_total'];

    public $incrementing = false;

    protected function grossTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products->reduce(function ($carry, $product) {
                $carry += $product->item_total * $product->pivot->quantity;
                return $carry;
            }, 0),
        );
    }

    protected function vatTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products->reduce(function ($carry, $product) {
                $carry += $product->vat * $product->pivot->quantity;
                return $carry;
            }, 0),
        );
    }

    protected function netTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->products->reduce(function ($carry, $product) {
                $carry += $product->price * $product->pivot->quantity;
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
