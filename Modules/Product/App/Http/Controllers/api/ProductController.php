<?php

namespace Modules\Product\App\Http\Controllers\api;

use Modules\Product\DTO\ProductDto;
use App\Http\Controllers\Controller;
use Modules\Product\Service\ProductService;
use Modules\Product\App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware(['auth:sanctum']);
        $this->productService = $productService;
    }

    public function index()
    {
        return $this->productService->findAll();
    }

    public function show($id)
    {
        return $this->productService->findById($id);
    }

    public function store(ProductRequest $request)
    {
        $data = (new ProductDto($request))->dataFromRequest();
        $product = $this->productService->create($data);
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    public function update(ProductRequest $request, $id)
    {
        $data = (new ProductDto($request))->dataFromRequest();
        $product = $this->productService->update($id, $data);
        if (!$product) {
            return response()->json(['message' => 'Product not found or update failed', 'status' => false], 404);
        }
        return response()->json(['message' => 'Product updated successfully', 'status' => $product], 200);
    }

    public function destroy($id)
    {
        $product = $this->productService->delete($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found or delete failed', 'status' => false], 404);
        }
        return response()->json(['message' => 'Product deleted successfully', 'status' => $product], 200);
    }
}
