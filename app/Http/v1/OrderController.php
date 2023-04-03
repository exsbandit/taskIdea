<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\Order\OrderIndexRequest;
use App\Http\Requests\v1\Order\OrderShowRequest;
use App\Http\Requests\v1\Order\OrderStoreRequest;
use App\Http\Requests\v1\Order\OrderUpdateRequest;
use App\Http\Resources\v1\Order\OrderWithDiscountResource;
use App\Http\Resources\v1\Order\OrderWithProductResource;
use App\Models\Order;
use App\Services\v1\Order\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Helpers\Response;

class OrderController extends Controller
{
    protected $orders;

    /**
     * OrderController constructor.
     * @param OrderService $orders
     */
    public function __construct(OrderService $orders)
    {
        $this->orders = $orders;
    }


    /**
     * @param OrderIndexRequest $request
     * @return JsonResponse
     */
    public function index(OrderIndexRequest $request): JsonResponse
    {
        return Response::run($this->orders->repository->get());
    }

    /**
     * @param OrderIndexRequest $request
     * @return JsonResponse
     */
    public function orderedProducts(OrderIndexRequest $request): JsonResponse
    {
        return Response::run(OrderWithProductResource::collection($this->orders->repository->orderedProducts()));
    }

    /**
     * @param OrderIndexRequest $request
     * @return JsonResponse
     */
    public function orderedDiscounts(OrderIndexRequest $request): JsonResponse
    {
        return Response::run(OrderWithDiscountResource::collection($this->orders->repository->orderedDiscounts()));
    }

    /**
     * @param OrderStoreRequest $request
     * @return JsonResponse
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {
        return Response::run($this->orders->repository->create($request->validated()));
    }

    /**
     * @param OrderShowRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function show(OrderShowRequest $request, Order $order): JsonResponse
    {
        return Response::run($this->orders->repository->find($order->id));
    }
}
