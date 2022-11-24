<?php
namespace App\Controllers;
ob_start();
use App\Models\Product;
use Dompdf\Dompdf;

class ProductController {

    function __construct()
    {
        echo "<br>Constructor clase ProductController";
    }

    public function index()
    {
        echo "<br>Index ProductController";

        $products = Product::all();
        require "../app/views/product/index.php";
    }

    public function show($arguments)
    {
        echo "<br>Show ProductController";
        list($id) = $arguments;

        if (!$id || !is_numeric($id)) {
            
            header('Location: /Product/Show/1');
            exit();
        }

        $product = Product::find($id);
        require "../app/views/product/show.php";
    }

    public function pdf()
    {
        echo "<br>PDF ProductController";

        $dompdf = new Dompdf();
        $dompdf->loadHtml('<h1>Hola mundo</h1><br><a href="https://parzibyte.me/blog">By Parzibyte</a>');
        $dompdf->render();
        // header("Content-type: application/pdf");
        // header("Content-Disposition: inline; filename=documento.pdf");
        // echo $dompdf->output();
        $dompdf->stream();
    }
}