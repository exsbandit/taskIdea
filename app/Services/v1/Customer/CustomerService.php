<?php

namespace App\Services\v1\Customer;

use App\Services\v1\Customer\Repositories\CustomerRepository;

class CustomerService
{
    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }
}
