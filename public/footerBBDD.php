<?php

function footerBBDD($options)
{
    echo "<br><hr>";
    echo "<p style='text-align: center'>";

    $links = "";

    foreach ($options as $option) {
        $links .= "<a href='bbdd$option.php'>$option</a> | ";
    }

    $links = substr_replace($links, "", -2);
    echo $links;

    echo "</p>";
}
