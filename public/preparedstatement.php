<?php

$dsn = "mysql:dbname=demo;host=db";
$user = "dbuser";
$password = "secret";

try {
    
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}