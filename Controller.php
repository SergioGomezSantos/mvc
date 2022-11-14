<?php

require "../models/Product.php";

class Controller
{
    function __construct()
    {
        
    }

    public function home()
    {
        $products = Product::all();
        require "../views/home.php";
    }
    
    public function show()
    {
        $id = $_GET['id'];
        $product = Product::find($id);
        require "../views/show.php";
    }
}
