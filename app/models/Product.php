<?php

namespace App\Models;

use PDO;
use DateTime;
use Core\Model;

class Product extends Model {

    public $id;
    public $name;
    public $type_id;
    public $price;
    public $fecha_compra;

    function __construct()
    {
        $this->fecha_compra = DateTime::createFromFormat('Y-m-d', $this->fecha_compra);
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
        $db = Product::db();
        $statement = $db->prepare('INSERT INTO products (name, price, fecha_compra) VALUES(:name, :price, :fecha_compra)');

        $statement->bindValue(':name', $this->name);

        $this->price = floatval($this->price);
        $statement->bindValue(':price', $this->price);

        $this->fecha_compra = DateTime::createFromFormat("d-m-Y", $this->fecha_compra);
        $statement->bindValue(':fecha_compra', $this->fecha_compra->format("Y-m-d"));
        
        return $statement->execute();
    }

    public function save()
    {
        $db = Product::db();
        $statement = $db->prepare('UPDATE products SET name = :name, price = :price, fecha_compra = :fecha_compra WHERE id = :id');

        $statement->bindValue(':id', $this->id);
        $statement->bindValue(':name', $this->name);

        $this->price = floatval($this->price);
        $statement->bindValue(':price', $this->price);

        $this->fecha_compra = DateTime::createFromFormat("d-m-Y", $this->fecha_compra);
        $statement->bindValue(':fecha_compra', $this->fecha_compra->format("Y-m-d"));

        return $statement->execute();
    }

    public function delete()
    {
        $db = Product::db();
        $stmt = $db->prepare('DELETE FROM products WHERE id = :id');
        
        $stmt->bindValue(':id', $this->id);
        
        return $stmt->execute();
    }
}