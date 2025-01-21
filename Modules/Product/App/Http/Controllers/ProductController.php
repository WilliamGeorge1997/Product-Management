<?php

namespace Modules\Product\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Product\App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user-web' , 'prevent-back-history']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product::products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::products.create');
    }

    /**
     * Show the specified resource.
     */
    public function show(Product $product)
    {
        return view('product::products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product::products.edit', compact('product'));
    }

}
