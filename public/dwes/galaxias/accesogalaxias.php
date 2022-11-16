<?php

namespace Dwes\Galaxias;

echo "<br>" . "Namespace actual: " . __NAMESPACE__ . "<br>" . "<hr>";


include "galaxia1.php";
echo "<br>" . "<b>Sin direccionamiento:</b>";

echo "<br>" . RADIO;
observar("Vía Láctea");

$galaxia = new Galaxia();
Galaxia::muerte(); // $galaxia::muerte();


echo "<br>";


include "pegaso/galaxiaPegaso.php";
echo "<br>" . "<b>Direccionamiento Relativo:</b>";

echo "<br>" . Pegaso\RADIO;
Pegaso\observar("Vía Láctea");

$pegaso = new Pegaso\Galaxia();
Pegaso\Galaxia::muerte(); // $galaxia::muerte();


echo "<br>";


echo "<br>" . "<b>Direccionamiento Absoluto:</b>";

echo "<br>" . \Dwes\Galaxias\Pegaso\RADIO;
\Dwes\Galaxias\Pegaso\observar("Vía Láctea");

$pegaso = new \Dwes\Galaxias\Pegaso\Galaxia();
\Dwes\Galaxias\Pegaso\Galaxia::muerte(); // $galaxia::muerte();


echo "<br>";


use const \Dwes\Galaxias\Pegaso\RADIO;
use function \Dwes\Galaxias\Pegaso\observar;
use \Dwes\Galaxias\Pegaso\Galaxia as AliasGalaxiaPegaso;

echo "<br>" . "<b>Use: </b>";

echo "<br>" . RADIO;
observar('Use');
$useGalaxia = new AliasGalaxiaPegaso();
AliasGalaxiaPegaso::muerte();