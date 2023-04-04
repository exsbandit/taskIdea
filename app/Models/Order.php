<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products(): HasMany
    {
        return $this->hasMany(OrderedProduct::class, 'orderId', 'id')->with('product');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(OrderedDiscount::class, 'orderId', 'id');
    }
}
