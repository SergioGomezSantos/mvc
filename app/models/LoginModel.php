<?php

namespace App\Models;

class LoginModel {

    const DB_CHECK_ERROR = "Credenciales incorrectos";

    public function __construct()
    {
    }

    public function checkBBDD($userName, $password)
    {
        require "../bbdd.php";

        try {

            $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
            $sql = "SELECT usuario, password FROM credenciales WHERE (usuario = '$userName')";
            $dbResponse = $bd->query($sql);
            $select = $dbResponse->fetch();

            if ($dbResponse->rowCount() === 1 && $select['usuario'] === $userName && password_verify($password, $select['password'])) {

                $_SESSION = array();
                $_SESSION['userName'] = $userName;
                header('Location: /agenda');
                die();

            } else {

                $_SESSION['error'] = $this::DB_CHECK_ERROR;
                $_SESSION['prevForm']['prevUsername'] = $userName;
            }
            
        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }
    }
}