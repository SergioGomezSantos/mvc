<?php

class AgendaModel
{

    const INSERT_OK_INFO = "%s insertada con éxito";
    const INSERT_ERROR_INFO = "Fallo al insertar la %s: %s";

    public function checkBBDD()
    {
        require "../bbdd.php";
    }

    public function checkInsertBBDD($type, $name, $surnames, $address, $phone)
    {
        // $_SESSION['error'] = sprintf($this::INSERT_ERROR_INFO, ucwords($type), "");
        $_SESSION['ok'] = sprintf($this::INSERT_OK_INFO, ucwords($type));
        unset($_SESSION['prevForm']);
    }
}
