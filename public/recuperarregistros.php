<?php

$login = new Login();
$login->all();

class Login {

    protected $name = null;
    protected $password = null;

    public function __construct()
    {
    }

    public static function all()
    {
        $dsn = "mysql:host=db;dbname=demo";
        $usuario = "dbuser";
        $password = "secret";

        try {

            $db = new PDO($dsn, $usuario, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM credentials";
            $sentencia = $db->prepare($sql);

            $sentencia->setFetchMode(PDO::FETCH_CLASS, Login::class);
            $sentencia->execute();

            while ($obj = $sentencia->fetch()) {
                
                echo "Nombre: " . $obj->name;
                echo "<br>";
                echo "Password: " . $obj->password;
                echo "<br>";
            }

            $credentials = $sentencia->fetchAll();
            foreach ($credentials as $credential) {
                echo "Nombre: " . $credential->name;
                echo "<br>";
                echo "Password: " . $credential->password;
                echo "<br>";
            }

        } catch (PDOException $e) {
            echo "Error BBDD: " . $e->getMessage();
        }
    }
}