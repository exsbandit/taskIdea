<?php

namespace App\Services\v1\Customer\Repositories;

use App\Models\Customer;
use App\Repositories\v1\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    public function prepareFilters(Builder $query, array $filters): Builder
    {
        if (isset($filters['name'])) {
            $query->where('name', 'LIKE', "{$filters['name']}%");
            unset($filters['name']);
        }

        return parent::prepareFilters($query, $filters);
    }
}
