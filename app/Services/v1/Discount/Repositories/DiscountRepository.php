<?php

namespace App\Services\v1\Discount\Repositories;

use App\Models\Discount;
use App\Repositories\v1\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class DiscountRepository extends BaseRepository implements DiscountRepositoryInterface
{
    public function __construct(Discount $model)
    {
        parent::__construct($model);
    }

}
