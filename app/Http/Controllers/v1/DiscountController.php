<?php

namespace App\Http\Controllers\v1;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Discount\DiscountFinderRequest;
use App\Http\Requests\v1\Discount\DiscountStoreRequest;
use App\Models\Order;
use App\Services\v1\Discount\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected $discounts;

    public function __construct(DiscountService $discounts)
    {
        $this->discounts = $discounts;
    }

    public function index(): JsonResponse
    {
        return Response::run($this->discounts->repository->get());
    }

    public function store(DiscountStoreRequest $request): JsonResponse
    {
        return Response::run($this->discounts->repository->create($request->validated()));
    }
    public function discountFinder(DiscountFinderRequest $request, Order $order): JsonResponse
    {
        dd($order->products->sum('quantity'));
        return Response::run($this->discounts->repository->discountFinder($request->validated()));
    }
}
