<?php

namespace App\Models;

class LoginModel {

    const TABLE_COLUMN = "Tables_in_agenda";
    const TABLE_NAME = "credenciales";
    const LOGIN_ERROR = "Credenciales incorrectos";

    public function __construct()
    {
    }

    // Declaro $exist como false.
    // Con los credenciales para la BBDD, hago un SHOW TABLES y si hay respuesta, compruebo fila por fila si el nombre de cada tabla coincide con TABLE_NAME
    // Si coincide, marco $exist como true. Devuelve $exist.
    public function checkBBDD()
    {
        $exist = false;

        require "../bbdd.php";
        $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
        $sql = "SHOW TABLES";
        $dbResponse = $bd->query($sql);

        if ($dbResponse->rowCount() > 0) {

            foreach ($dbResponse as $row) {

                if ($row[$this::TABLE_COLUMN] === $this::TABLE_NAME) {
                    $exist = true;
                }
            }
        }

        return $exist;
    }

    // Compruebo si la tabla existe (checkBBDD()). Si existe, creo la tabla con los credenciales para la BBDD. El .sql ya lleva los datos, por lo que ya se insertan.
    //                                                        Compruebo el resultado para marcar ok/error
    //                                             Si no existe, marco el error.
    public function initializeBBDD()
    {

        $exist = $this->checkBBDD();

        if (!$exist) {
            
            require "../bbdd.php";

            try {

                $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);

                $sql = file_get_contents('../documents/agenda.sql');
                $dbResponse = $bd->exec($sql);

                if ($dbResponse === 0) {

                    $_SESSION['ok'] = INITIALIZE_TABLE_OK_INFO;
                    
                } else {

                    $_SESSION['error'] = INITIALIZE_TABLE_ERROR_INFO;
                }

            } catch (\PDOException $e) {

                $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
            }

        } else {

            $_SESSION['error'] = INITIALIZE_TABLE_ERROR_INFO;
        }
    }

    // Con los credenciales para la BBDD, hago el select respecto al nombre de usuario que recibo del controller.
    // Si recibo datos, quiere decir que el nombre de usuario es correcto, por lo que compruebo si las contraseñas coinciden.
    // Si todo coincide, guardo la información en la sesión, quito lo que haya en prevForm y redirección a /agenda.
    // Si algo está mal, marco el error y guardo el nombre de usuario en prevForm para poder volver a escribirlo en el formulario
    public function checkLogin($userName, $password)
    {
        require "../bbdd.php";

        try {

            $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
            $sql = "SELECT usuario, password FROM credenciales WHERE (usuario = '$userName')";
            $dbResponse = $bd->query($sql);
            $select = $dbResponse->fetch();

            if ($dbResponse->rowCount() === 1 && password_verify($password, $select['password'])) {

                $_SESSION = array();
                $_SESSION['userName'] = $userName;
                unset($_SESSION['prevForm']);
                header('Location: /agenda');
                die();

            } else {

                $_SESSION['error'] = $this::LOGIN_ERROR;
                $_SESSION['prevForm']['prevUsername'] = $userName;
            }
            
        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }
    }
}