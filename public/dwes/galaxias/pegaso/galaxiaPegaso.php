<?php

namespace Dwes\Galaxias\Pegaso;

const RADIO = 3.17;

function observar($mensaje)
{
    echo "<br>" . "Observando Pegaso desde " . $mensaje;
}


class Galaxia
{

    public function __construct()
    {
        $this->nacimiennto();
    }

    private function nacimiennto()
    {
        echo "<br>" . "Nacimiento de la galaxia Pegaso";
    }

    static function muerte()
    {
        echo "<br>" . "Muerte de la galaxia Pegaso";
    }
}