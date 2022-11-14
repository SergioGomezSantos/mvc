<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <title>Show Product</title>
</head>

<body>

    <div>
        <h1>Información de un Producto</h1>
    </div>
    <hr><br>

    <div>
        <table>
            <tr>
                <td><b>Identificador</b></td>
                <td><b>Descripcion</b></td>
            </tr>

            <?php

                echo "<tr>";

                if ($product) {

                    echo "<td>$product[0]</td>";
                    echo "<td>$product[1]</td>";

                } else {

                    echo "<td>#</td>";
                    echo "<td>Sin Producto</td>";
                }
                
                echo "</tr>";
            ?>

        </table>

        <?php 

            if ($product) {
                echo '<a href="/Product/Show/' . (substr($_GET["url"], -1) + 1) . '">Siguiente Producto</a>';
            } else {
                echo '<a href="/Product/Show/1">Primer Producto</a>';
            }
        ?>
    </div>

    <br>
    <hr>
    
    <?php 
    require "footer.php";
    redirectHome();
    ?>

</body>

</html>