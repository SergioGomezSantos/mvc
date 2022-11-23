<?php

namespace App\Models;

use PDO;
use Core\Model;

class Product extends Model {

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
    
    public static function find($id)
    {
        return Product::PRODUCTS[$id-1];
    }

    // public static function all()
    // {
    //     //TODO 
    // }

    // public static function find($id)
    // {
    //     //TODO 
    // }

    public function insert()
    {
        //TODO
    }

    public function delete()
    {
        //TODO
    }

    public function save()
    { 
        //TODO
    }
}