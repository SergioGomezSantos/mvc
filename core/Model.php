<?php

namespace Core;

// Constante para mostrar el error
const DB_ERROR = "Error al conectar con la base de datos: %s";

// Require y Uses para bbdd.php, que contiene los valores de acceso a la BBDD
require_once '../config/bbdd.php';
use const Config\DSN;
use const Config\USERNAME;
use const Config\PASSWORD;

use PDO;
use PDOException;

class Model
{
    // Crea la conexión con la base de datos y la devuelve
    // Si falla el proceso, marca el error.

    protected static function db()
    {
        try {

            $db = new PDO(DSN, USERNAME, PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            $_SESSION['error'] = sprintf(DB_ERROR, $e->getMessage());
        }
        
        return $db;
    }
}