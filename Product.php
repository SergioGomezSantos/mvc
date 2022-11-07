<?php

class Product {

    const PRODUCTS = [
        array(1, 'Product A'),
        array(2, 'Product B'),
        array(3, 'Product C'),
        array(4, 'Product D')
    ];

    function __construct()
    {
        
    }

    public static function all()
    {
        return Product::PRODUCTS;
    }
    
    public function find($id)
    {
        return Product::PRODUCTS[$id-1];
    }
}