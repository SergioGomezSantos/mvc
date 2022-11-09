<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>All Products</title>
</head>

<body>

    <div>
        <h1>Inventario de Productos</h1>
    </div>
    <hr><br>

    <div>
        <table>
            <tr>
                <td><b>Identificador</b></td>
                <td><b>Descripcion</b></td>
                <td><b>Link</b></td>
            </tr>

            <?php
            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>$product[0]</td>";
                echo "<td>$product[1]</td>";
                echo "<td><a href='index.php?method=show&id=$product[0]'>Detalles</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <br>
    <hr>
    
    <?php 
    require "footer.php";
    redirectShow();
    ?>

</body>

</html>