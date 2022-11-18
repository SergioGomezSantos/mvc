<?php


if ($_SESSION['error']) {

    echo '<div id="divError">' . $_SESSION['error'] . '</div>';
}

if ($_SESSION['ok']) {
    
    echo '<div id="divOK">' . $_SESSION['ok'] . '</div>';
}

unset($_SESSION['ok']);
unset($_SESSION['error']);
