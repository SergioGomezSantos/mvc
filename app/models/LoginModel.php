<?php

namespace App\Models;

class LoginModel {

    const TABLE_COLUMN = "Tables_in_agenda";
    const TABLE_NAME = "credenciales";
    const LOGIN_ERROR = "Credenciales incorrectos";

    public function __construct()
    {
    }

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

    public function checkLogin($userName, $password)
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

                $_SESSION['error'] = $this::LOGIN_ERROR;
                $_SESSION['prevForm']['prevUsername'] = $userName;
            }
            
        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }
    }
}