<?php

echo "<br>" . "Hora: " . time();

echo "<br>" . "Hora en un mes: " . strtotime("+1 month");

echo "<br>" . "Fecha: " . date("d/F/y");

echo "<br>";
$dateTime = new DateTime("now");
var_dump($dateTime);

echo "<br>";
$dateTime2 = new DateTime("+11 week");
var_dump($dateTime2);
echo "Intento de fecha: " . $dateTime2->format("d@M@Y");;

echo "<br>";
$dateTime3 = Datetime::createFromFormat("d/m/yy", "09/07/2018");
echo "Fecha Personalizada: ";
var_dump($dateTime3);
echo "<br>" . "Fecha en España: " . $dateTime3->format("j-n-y");