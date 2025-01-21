<?php

namespace Modules\Product\App\Http\Controllers\api;

use Modules\Product\DTO\ProductDto;
use App\Http\Controllers\Controller;
use Modules\Product\Service\ProductService;
use Modules\Product\App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->middleware(['auth:sanctum' , 'web']);
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
        return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
    }

    public function destroy($id)
    {
        $product = $this->productService->delete($id);
        return response()->json(['message' => 'Product deleted successfully', 'product' => $product], 200);
    }
}
