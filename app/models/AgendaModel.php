<?php

namespace App\Models;

// Uso, Require y Extends sobre Model, que contiene la función que se encarga de crear la conexión a la base de datos.
use Core\Model;
require_once "../core/Model.php";

class AgendaModel extends Model
{

    // Definir constantes a utlizar. El nombre de la tabla, la columna (Para SHOW TABLES) y todos los ok/errores.
    const TABLE_NAME = "ContactosTrabajo";
    const TABLE_COLUMN = "Tables_in_agenda";
    const INITIALIZE_TABLE_OK_INFO = "Tabla Inicializada";
    const INITIALIZE_TABLE_ERROR_INFO = "Error al inicializar la tabla";
    const RESET_TABLE_OK_INFO = "Valores Reseteados";
    const RESET_TABLE_ERROR_INFO = "Error al resetear la tabla";
    const XML_NOT_FOUND = "Archivo XML no encontrado";
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
    // Con el acceso a la BBDD, hago un SHOW TABLES y si hay respuesta, compruebo fila por fila si el nombre de cada tabla coincide con TABLE_NAME
    // Si coincide, marco $exist como true. Devuelve $exist.
    public function checkBBDD()
    {
        $exist = false;

        $db = AgendaModel::db();

        $sql = "SHOW TABLES";
        $dbResponse = $db->query($sql);

        if ($dbResponse->rowCount() > 0) {

            foreach ($dbResponse as $row) {

                if ($row[$this::TABLE_COLUMN] === $this::TABLE_NAME) {
                    $exist = true;
                }
            }
        }

        return $exist;
    }

    // Compruebo si la tabla existe (checkBBDD()). Si existe, creo la tabla con el acceso a la BBDD. Si se crea, lanzo resetBBDD() y marco el OK.
    //                                                                                               Si no se crea, marco el error.
    //                                             Si no existe, marco el error.
    public function initializeBBDD()
    {
        $exist = $this->checkBBDD();

        if (!$exist) {

            $db = AgendaModel::db();

            // He añadido una id auto incremental para evitar problemas de duplicidad. Apellidos y Email pueden ser NULL
            $sql = "CREATE TABLE ContactosTrabajo ( id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                                        tipo varchar(255) NOT NULL, 
                                                        nombre varchar(255) NOT NULL, 
                                                        apellidos varchar(255) NULL, 
                                                        direccion varchar(255) NOT NULL, 
                                                        telefono int(11) NOT NULL,
                                                        email varchar(255) NULL )
                                                        ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $dbResponse = $db->query($sql);

            if ($dbResponse->rowCount() === 0) {

                $this->resetBBDD();
                $_SESSION['ok'] = $this::INITIALIZE_TABLE_OK_INFO;
                
            } else {

                $_SESSION['error'] = $this::INITIALIZE_TABLE_ERROR_INFO;
            }

        } else {

            $_SESSION['error'] = $this::INITIALIZE_TABLE_ERROR_INFO;
        }
    }

    // Compruebo si la tabla existe (checkBBDD()). Si no existe, marco el error. 
    //                                             Si existe, delcaro $valid como true y: 

    //    1. TRUNCATE TABLE. Si truncate falla, marco el error.

    //    2. Leo el .xml. Si no existe, marco el error.
    //                    Si existe, inserto los contactos. Si algun contacto falla, cambio $valid a false. 
    //                               Al terminar el .xml, compruebo $valid para marcar ok/error.
    public function resetBBDD()
    {
        $exist = $this->checkBBDD();

        if ($exist) {

            $valid = true;
            $db = AgendaModel::db();

            $sqlTruncate = sprintf("TRUNCATE TABLE %s", $this::TABLE_NAME);
            $dbResponseTruncate = $db->query($sqlTruncate);

            if ($dbResponseTruncate) {
                
                $xmlData = simplexml_load_file("../documents/agenda.xml");

                if ($xmlData) {

                    foreach ($xmlData->children() as $contact) {
                    
                        $type = $contact["tipo"];
                        $name = $contact->nombre;
                        $surnames = $contact->apellidos;
                        $address = $contact->direccion;
                        $phone = $contact->telefono;
                        $email = $contact->email;

                        // insertBBDD() es una función privada para hacer el insert. Se inserta en 2 funciones distintas así que la he separado para no repetir código.
                        $dbResponseInsert = $this->insertBBDD($db, $type, $name, $surnames, $address, $phone, $email);
                        
                        if (!$dbResponseInsert) {
                            $valid = false;
                        }
                    }

                    $valid ? $_SESSION['ok'] = $this::RESET_TABLE_OK_INFO : $_SESSION['error'] = $this::RESET_TABLE_ERROR_INFO;

                } else {

                    $_SESSION['error'] = $this::XML_NOT_FOUND;
                }

            } else {

                $_SESSION['error'] = $this::RESET_TABLE_ERROR_INFO;
            }

        } else {

            $_SESSION['error'] = $this::RESET_TABLE_ERROR_INFO;
        }
    }

    // Función privada para no repetir código. Recie la $bd y los valores. 
    // Ejecuta el insert y devuelve el resultado
    private function insertBBDD($db, $type, $name, $surnames, $address, $phone, $email) {

        $sqlInsert = sprintf("INSERT INTO %s (tipo, nombre, apellidos, direccion, telefono, email) 
                                VALUES ('$type', '$name', '$surnames', '$address', '$phone', '$email')", $this::TABLE_NAME);

        return $db->query($sqlInsert);
    }

    // Con el acceso a la BBDD, inserto los valores que recibo del controller. Compruebo si se ha insertado y marco ok/error. 
    // Si insert devuelve ok, reseteo prevForm porque ya no hace falta guardar los valores del formulario.
    public function checkInsertBBDD($type, $name, $surnames, $address, $phone, $email)
    {
        $db = AgendaModel::db();
        $dbResponseInsert = $this->insertBBDD($db, $type, $name, $surnames, $address, $phone, $email);

        if ($dbResponseInsert) {

            $_SESSION['ok'] = sprintf($this::INSERT_OK_INFO, ucwords($type));
            unset($_SESSION['prevForm']);

        } else {

            $_SESSION['error'] = sprintf($this::INSERT_ERROR_INFO, ucwords($type), "");
        }
    }

    // Con el acceso a la BBDD, hago un select para todas las filas de la tabla. Creo el array de contactos.
    // Si devuelve datos, los leo línea a línea y voy creando arrays con los datos para guardarlos en el array de contactos
    // Devuelve el array de contactos. Si no ha recibido datos del select, el array estaŕa vacío.
    public function getContactsList() 
    {
        $db = AgendaModel::db();
        $sql = sprintf("SELECT id, nombre from %s", $this::TABLE_NAME);
        $dbResponse = $db->query($sql);

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

    // Con el acceso a la BBDD, hago el delete con la id que recivo del controller
    // Compruebo el resultado para marcar ok/error
    public function deleteBBDD($removeContact) {

        $db = AgendaModel::db();

        $sqlDelete = sprintf("DELETE FROM %s WHERE  id like '$removeContact'", $this::TABLE_NAME);
        $dbResponseDelete = $db->query($sqlDelete);

        if ($dbResponseDelete->rowCount() > 0) {
                
            $_SESSION['ok'] = $this::DELETE_OK_INFO;

        } else {

            $_SESSION['error'] = $this::DELETE_ERROR_INFO;
        }
    }

    // Con el acceso a la BBDD, hago un select para la id que recivo del controller.
    // Compruebo el resultado. Si recibo datos, los guardo en prevForm para utilizarlo en el formulario.
    //                         Si no recibo datos, marco el error.

    // Puede recibir $forUpdate, porque el método se llama tanto desde la parte de search como desde la parte de update
    // Si $forUpdate es true/false queire decir que viene de update/search, por lo que se marca el ok/error y se hace la redirección adecuadamente
    public function searchBBDD($contactId, $forUpdate = false)
    {
        $db = AgendaModel::db();

        $sqlSearch = sprintf("SELECT * FROM %s WHERE id like '$contactId'", $this::TABLE_NAME);
        $dbResponseSearch = $db->query($sqlSearch);

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
                $_SESSION['ok'] = $this::SEARCH_OK_INFO;
            }

        } else {

            $_SESSION['error'] = $this::SEARCH_ERROR_INFO;

            if ($forUpdate) {

                header('Location: /agenda/update');
                die();
    
            } else {
    
                header('Location: /agenda/search');
                die();
            }
        }     
    }

    // Con el acceso a la BBDD, hago el update con los datos que recibo sobre el contacto correspondiente a la id.
    // Compruebo el resultado para marcar ok/error.
    public function updateBBDD($type, $name, $surnames, $address, $phone, $email, $id)
    {
        $db = AgendaModel::db();

        $sqlUpdate = sprintf("UPDATE ContactosTrabajo SET tipo = '$type', nombre = '$name', apellidos ='$surnames', direccion = '$address',
                                                        telefono = '$phone', email = '$email' WHERE id like '$id'", $this::TABLE_NAME);

        $dbResponseUpdate = $db->query($sqlUpdate);
        
        if ($dbResponseUpdate->rowCount() > 0) {

            $_SESSION['ok'] = $this::UPDATE_OK_INFO;
            return true;

        } else {

            $_SESSION['error'] = $this::UPDATE_ERROR_INFO;
            return false;
        }
    }
}
