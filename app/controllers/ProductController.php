<?php

namespace App\Controllers;

require "../app/models/Product.php";
use App\Models\Product;

class ProductController {

    function __construct()
    {
        echo "<br>Constructor clase ProductController";
    }

    public function index()
    {
        echo "<br>Index ProductController";

        $products = Product::all();
        require "../app/views/product/home.php";
    }

    public function show($arguments)
    {
        echo "<br>Show ProductController";

        $product = Product::find($arguments[0]);
        require "../app/views/product/show.php";
    }
}