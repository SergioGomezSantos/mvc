<?php

namespace App\Models;

class AgendaModel
{

    const TABLE_COLUMN = "Tables_in_agenda";
    const TABLE_NAME = "ContactosTrabajo";
    const INITIALIZE_TABLE_OK_INFO = "Tabla Inicializada";
    const INITIALIZE_TABLE_ERROR_INFO = "Error al inicializar la tabla";
    const RESET_TABLE_OK_INFO = "Valores Reseteados";
    const RESET_TABLE_ERROR_INFO = "Error al resetear la tabla";
    const INSERT_OK_INFO = "%s insertada con éxito";
    const INSERT_ERROR_INFO = "Fallo al insertar la %s: %s";

    public function __construct()
    {
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

    public function initializeBBDD()
    {
        $exist = $this->checkBBDD();

        if (!$exist) {

            require "../bbdd.php";

            try {

                $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
                $sql = "CREATE TABLE ContactosTrabajo ( tipo varchar(255) NOT NULL, 
                                                          nombre varchar(255) NOT NULL, 
                                                          apellidos varchar(255) NULL, 
                                                          direccion varchar(255) NOT NULL, 
                                                          telefono int(11) NOT NULL,
                                                          email varchar(255) NULL )
                                                          ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                $dbResponse = $bd->query($sql);

                if ($dbResponse->rowCount() === 0) {

                    $_SESSION['ok'] = $this::INITIALIZE_TABLE_OK_INFO;
                    $this->resetBBDD();
                } else {

                    $_SESSION['error'] = $this::INITIALIZE_TABLE_ERROR_INFO;
                }

            } catch (\PDOException $e) {

                $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
            }

        } else {

            $_SESSION['error'] = $this::INITIALIZE_TABLE_ERROR_INFO;
        }
    }

    public function resetBBDD()
    {
        $exist = $this->checkBBDD();

        if ($exist) {

            require "../bbdd.php";

            try {

                $valid = true;
                $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);

                $sqlTruncate = sprintf("TRUNCATE TABLE %s", $this::TABLE_NAME);
                $dbResponseTruncate = $bd->query($sqlTruncate);

                if ($dbResponseTruncate) {
                    
                    $xmlData = simplexml_load_file("../documents/agenda.xml");

                    foreach ($xmlData->children() as $contact) {
                        
                        $type = $contact["tipo"];
                        $name = $contact->nombre;
                        $surnames = $contact->apellidos;
                        $address = $contact->direccion;
                        $phone = $contact->telefono;
                        $email = $contact->email;

                        $sqlInsert = sprintf("INSERT INTO %s (tipo, nombre, apellidos, direccion, telefono, email) 
                                VALUES ('$type', '$name', '$surnames', '$address', '$phone', '$email')", $this::TABLE_NAME);

                        $dbResponseInsert = $bd->query($sqlInsert);
                        
                        if (!$dbResponseInsert) {
                            $valid = false;
                        }
                    }

                } else {

                    $valid = false;
                }

                $valid ? $_SESSION['ok'] = $this::RESET_TABLE_OK_INFO : $_SESSION['error'] = $this::RESET_TABLE_ERROR_INFO;

            } catch (\PDOException $e) {

                $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
            }

        } else {

            $_SESSION['error'] = $this::RESET_TABLE_ERROR_INFO;
        }

        header('Location: /');
    }

    public function checkInsertBBDD($type, $name, $surnames, $address, $phone)
    {
        // $_SESSION['error'] = sprintf($this::INSERT_ERROR_INFO, ucwords($type), "");
        $_SESSION['ok'] = sprintf($this::INSERT_OK_INFO, ucwords($type));
        unset($_SESSION['prevForm']);
    }
}
