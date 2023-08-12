<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            new ProductCollection(Product::all())
        );
    }

    /**
     * @throws ValidationException
     * @throws ApiErrorException
     */
    public function store(Request $request): JsonResponse
    {
        $this
            ->validate(request: $request, rules: [
                'name' => 'required|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric'
            ]);

        $product = Cashier::stripe()->products->create([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $price = Cashier::stripe()->prices->create([
            'currency' => 'brl',
            'product' => $product->id,
            'unit_amount' => $request->input('price')
        ]);

        $product = Cashier::stripe()->products->update($product->id, [
            'default_price' => $price->id
        ]);

        $product = Product::query()->create([
            'sid' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'pid' => $price->id,
            'active' => $product->active
        ]);

        return response()->json(
            data: new ProductResource($product),
            status: 201
        );
    }
}
