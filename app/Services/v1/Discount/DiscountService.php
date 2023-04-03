<?php

namespace App\Services\v1\Discount;

use App\Services\v1\Discount\Repositories\DiscountRepository;

class DiscountService
{
    public $repository;

    /**
     * ProductService constructor.
     * @param DiscountRepository $repository
     */
    public function __construct(DiscountRepository $repository)
    {
        $this->repository = $repository;
    }
}
