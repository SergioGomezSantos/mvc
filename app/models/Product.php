<?php

namespace App\Models;

use PDO;
use Core\Model;

class Product extends Model {

    public $id;
    public $name;
    public $type_id;
    public $price;
    public $fecha_compra;

    function __construct()
    {
        
    }

    public static function all()
    {
        $db = Product::db();
        $statement = $db->query("SELECT * FROM products");
        $products = $statement->fetchAll(PDO::FETCH_CLASS, Product::class);

        return $products;
    }

    public static function find($id)
    {
        $db = Product::db();
        $statement = $db->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute(array(':id' => $id));
        $statement->setFetchMode(PDO::FETCH_CLASS, Product::class);
        $product = $statement->fetch(PDO::FETCH_CLASS);

        return $product;
    }

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