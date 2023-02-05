<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'picture_url'
    ];

    protected $casts = [
        'price' => 'float'
    ];

    public $incrementing = false;

    protected $hidden = ['deleted_at'];

    protected $dates = ['deleted_at'];

    protected $appends = ['vat', 'item_total'];

    protected function vat(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->price * (23/100), 2),
        );
    }

    protected function itemTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->price + $this->vat, 2),
        );
    }
}
