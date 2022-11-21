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
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "SELECT * FROM credentials";


        } catch (PDOException $e) {
            echo "Error BD: " . $e->getMessage();
        }
    }
}