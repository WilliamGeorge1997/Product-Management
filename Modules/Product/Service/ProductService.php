<?php

namespace Modules\Product\Service;

use Modules\Product\App\Models\Product;


class ProductService{

    public function findAll(){
        return Product::orderByDesc('id')->paginate(10);
    }

    public function findById($id){
        return Product::find($id);
    }

    public function create($data){
        return Product::create($data);
    }

    public function update($id, $data){
        $product = $this->findById($id);
        return $product->update($data);
    }

    public function delete($id){
        $product = $this->findById($id);
        return $product->delete();
    }
}
