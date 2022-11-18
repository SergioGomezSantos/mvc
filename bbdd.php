<?php

const DB_ERROR = "Error al conectar con la base de datos: %s";
const INITIALIZE_TABLE_OK_INFO = "Tabla Inicializada";
const INITIALIZE_TABLE_ERROR_INFO = "Error al inicializar la tabla";

$access = [
    "dsn" => "mysql:dbname=agenda;host=db",
    // "userName" => "dbuser",
    // "password" => "secret"
    "userName" => "root",
    "password" => "password"
];