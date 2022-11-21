<?php

// Si existe ok/error, muestra un div con el contenido en su color (id del div)

if ($_SESSION['error']) {

    echo '<div id="divError">' . $_SESSION['error'] . '</div>';
}

if ($_SESSION['ok']) {
    
    echo '<div id="divOK">' . $_SESSION['ok'] . '</div>';
}

// Unset a ambos al terminar para limpiarl la sesión
unset($_SESSION['ok']);
unset($_SESSION['error']);
