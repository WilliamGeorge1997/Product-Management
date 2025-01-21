<?php

namespace Modules\Product\DTO;

class ProductDto
{
    public $name;
    public $price;
    public $description;
    public $quantity;

    public function __construct($request)
    {
        $this->name = $request->get('name');
        $this->price = $request->get('price');
        $this->description = $request->get('description');
        $this->quantity = $request->get('quantity');
    }

    public function dataFromRequest(){
        $data = json_decode(json_encode($this), true);
        return $data;
    }
}
