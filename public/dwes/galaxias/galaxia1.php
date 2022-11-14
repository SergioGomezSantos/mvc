<?php

namespace Dwes\Galaxias;

const RADIO = 1.25;

function observar($mensaje)
{
    echo "<br>" . "Observando desde " . $mensaje;
}


class Galaxia
{

    public function __construct()
    {
        $this->nacimiennto();
    }

    public function nacimiennto()
    {
        echo "<br>" . "Nacimiento de la galaxia1";
    }

    static function muerte()
    {
        echo "<br>" . "Muerte de la galaxia1";
    }
}