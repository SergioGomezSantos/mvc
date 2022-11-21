<?php

class Login {

    protected $nombreUsu = null;
    protected $password = null;

    public function __construct()
    {

    }

    public static function all()
    {
        $dsn = "mysql:host=db;dbname=demo";
        $usuario = "dbusesr";
        $password = "secret";

        try {

            $db = new PDO($dsn, $usuario, $password);
            

        } catch (PDOException $e) {
            echo "Error BD: " . $e->getMessage();
        }
    }
}