<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class News
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @package App
 */
class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function discount(): HasOne
    {
        return $this->hasOne(OrderedProduct::class, 'productId', 'id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }
}
