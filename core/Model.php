<?php

namespace Core;

require_once '../config/bbdd.php';

const DB_ERROR = "Error al conectar con la base de datos: %s";

use const Config\DSN;
use const Config\USERNAME;
use const Config\PASSWORD;

use PDO;
use PDOException;

class Model
{
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