<?php

namespace App\Http\Controllers\v1;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Customer\CustomerIndexRequest;
use App\Http\Requests\v1\Customer\CustomerShowRequest;
use App\Http\Requests\v1\Customer\CustomerStoreRequest;
use App\Http\Requests\v1\Customer\CustomerUpdateRequest;
use App\Models\Customer;
use App\Services\v1\Customer\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected $customers;

    /**
     * CustomerController constructor.
     * @param CustomerService $customers
     */
    public function __construct(CustomerService $customers)
    {
        $this->customers = $customers;
    }

    /**
     * @param CustomerIndexRequest $request
     * @return JsonResponse
     */
    public function index(CustomerIndexRequest $request): JsonResponse
    {
        return Response::run($this->customers->repository->get());
    }

    /**
     * @param CustomerStoreRequest $request
     * @return JsonResponse
     */
    public function store(CustomerStoreRequest $request): JsonResponse
    {
        return Response::run($this->customers->repository->create($request->validated()));
    }

    /**
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return JsonResponse
     */
    public function update(CustomerUpdateRequest $request, Customer $customer): JsonResponse
    {
        return Response::run($this->customers->repository->update($customer, $request->validated()));
    }

    /**
     * @param CustomerShowRequest $request
     * @param Customer $customer
     * @return JsonResponse
     */
    public function show(CustomerShowRequest $request, Customer $customer): JsonResponse
    {
        return Response::run($this->customers->repository->find($customer->id));
    }
}
