<?php

namespace App\Models;

class AgendaModel
{

    // Definir constantes a utlizar. El nombre de la tabla, la columna (Para SHOW TABLES) y todos los ok/errores.
    const TABLE_NAME = "ContactosTrabajo";
    const TABLE_COLUMN = "Tables_in_agenda";
    const RESET_TABLE_OK_INFO = "Valores Reseteados";
    const RESET_TABLE_ERROR_INFO = "Error al resetear la tabla";
    const INSERT_OK_INFO = "Éxito al insertar %s";
    const INSERT_ERROR_INFO = "Fallo al insertar la %s: %s";
    const DELETE_OK_INFO = "Éxito al eliminar";
    const DELETE_ERROR_INFO = "Fallo al eliminar";
    const SEARCH_OK_INFO = "Éxito al buscar";
    const SEARCH_ERROR_INFO = "Fallo al buscar";
    const UPDATE_OK_INFO = "Éxito al actualizar";
    const UPDATE_ERROR_INFO = "Fallo al actualizar. Cambia los valores correctamente";

    public function __construct()
    {
    }

    // Declaro $exist como false.
    // Con los credenciales para la BBDD, hago un SHOW TABLES y si hay respuesta, compruebo fila por fila si el nombre de cada tabla coincide con TABLE_COLUMN
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

    public function initializeBBDD()
    {
        $exist = $this->checkBBDD();

        if (!$exist) {

            require "../bbdd.php";

            try {

                $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
                $sql = "CREATE TABLE ContactosTrabajo ( id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                          tipo varchar(255) NOT NULL, 
                                                          nombre varchar(255) NOT NULL, 
                                                          apellidos varchar(255) NULL, 
                                                          direccion varchar(255) NOT NULL, 
                                                          telefono int(11) NOT NULL,
                                                          email varchar(255) NULL )
                                                          ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                $dbResponse = $bd->query($sql);

                if ($dbResponse->rowCount() === 0) {

                    $this->resetBBDD();
                    $_SESSION['ok'] = INITIALIZE_TABLE_OK_INFO;
                    
                } else {

                    $_SESSION['error'] = INITIALIZE_TABLE_ERROR_INFO;
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

                        $dbResponseInsert = $this->insertBBDD($bd, $type, $name, $surnames, $address, $phone, $email);
                        
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

    private function insertBBDD($bd, $type, $name, $surnames, $address, $phone, $email) {

        $sqlInsert = sprintf("INSERT INTO %s (tipo, nombre, apellidos, direccion, telefono, email) 
                                VALUES ('$type', '$name', '$surnames', '$address', '$phone', '$email')", $this::TABLE_NAME);

        return $bd->query($sqlInsert);
    }

    public function checkInsertBBDD($type, $name, $surnames, $address, $phone, $email)
    {
        require "../bbdd.php";

        try {

            $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
            $dbResponseInsert = $this->insertBBDD($bd, $type, $name, $surnames, $address, $phone, $email);

            if ($dbResponseInsert) {

                $_SESSION['ok'] = sprintf($this::INSERT_OK_INFO, ucwords($type));
                unset($_SESSION['prevForm']);

            } else {

                $_SESSION['error'] = sprintf($this::INSERT_ERROR_INFO, ucwords($type), "");
            }
            
        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }
    }

    public function getContactsList() 
    {

        require "../bbdd.php";
        $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);
        $sql = sprintf("SELECT id, nombre from %s", $this::TABLE_NAME);
        $dbResponse = $bd->query($sql);

        $contacts = [];
        if ($dbResponse->rowCount() > 0) {

            foreach ($dbResponse as $row) {

                $contact = [
                    "id" => $row["id"],
                    "nombre" => $row["nombre"]
                ];

                $contacts[] = $contact;
            }
        }

        return $contacts;
    }

    public function deleteBBDD($removeContact) {

        require "../bbdd.php";

        try {

            $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);

            $sqlDelete = sprintf("DELETE FROM %s WHERE  id like '$removeContact'", $this::TABLE_NAME);
            $dbResponseDelete = $bd->query($sqlDelete);

            if ($dbResponseDelete->rowCount() > 0) {
                
                $_SESSION['ok'] = $this::DELETE_OK_INFO;

            } else {

                $_SESSION['error'] = $this::DELETE_ERROR_INFO;
            }

        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }        
    }

    public function searchBBDD($contactId, $forUpdate = false)
    {
        require "../bbdd.php";

        try {

            $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);

            $sqlSearch = sprintf("SELECT * FROM %s WHERE id like '$contactId'", $this::TABLE_NAME);
            $dbResponseSearch = $bd->query($sqlSearch);

            if ($dbResponseSearch->rowCount() === 1) {
                
                $searchContact = $dbResponseSearch->fetch();

                $_SESSION['prevForm']['prevType'] = $searchContact["tipo"];
                $_SESSION['prevForm']['prevName'] = $searchContact["nombre"];
                $_SESSION['prevForm']['prevSurnames'] = $searchContact["apellidos"];
                $_SESSION['prevForm']['prevAddress'] = $searchContact["direccion"];
                $_SESSION['prevForm']['prevPhone'] = $searchContact["telefono"];
                $_SESSION['prevForm']['prevEmail'] = $searchContact["email"];
                $_SESSION['prevForm']['id'] = $searchContact["id"];

                if (!$forUpdate) {
                    $_SESSION['ok'] = sprintf($this::SEARCH_OK_INFO, $contactName);
                }

            } else {

                $_SESSION['error'] = sprintf($this::SEARCH_ERROR_INFO, $contactName);

                if ($forUpdate) {

                    header('Location: /agenda/update');
                    die();

                } else {

                    header('Location: /agenda/search');
                    die();
                }
            }

        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }      
    }

    public function updateBBDD($type, $name, $surnames, $address, $phone, $email, $id)
    {
        require "../bbdd.php";

        try {

            $bd = new \PDO($access["dsn"], $access["userName"], $access["password"]);

            $sqlUpdate = sprintf("UPDATE ContactosTrabajo SET tipo = '$type', nombre = '$name', apellidos ='$surnames', direccion = '$address',
                                                            telefono = '$phone', email = '$email' WHERE id like '$id'", $this::TABLE_NAME);

            $dbResponseUpdate = $bd->query($sqlUpdate);
            
            if ($dbResponseUpdate->rowCount() > 0) {

                $_SESSION['ok'] = sprintf($this::UPDATE_OK_INFO, ucwords($name));
                return true;

            } else {

                $_SESSION['error'] = sprintf($this::UPDATE_ERROR_INFO, ucwords($name), "");
                return false;
            }
            
        } catch (\PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }
    }
}
