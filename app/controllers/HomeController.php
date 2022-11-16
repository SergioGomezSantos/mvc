<?php

namespace App\Controllers;

class HomeController {

    function __construct()
    {
        echo "<br>Constructor clase HomeController";
    }

    public function index()
    {
        require "../app/views/home/home.php";
    }

    public function show()
    {
        echo "<br>Show HomeController";
    }
}