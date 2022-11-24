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
                <td><b>Id</b></td>
                <td><b>Name</b></td>
                <td><b>Price</b></td>
                <td><b>Fecha_Compra</b></td>
                <td><b>Detalles</b></td>
            </tr>

            <?php
            foreach ($products as $product) {

                echo "<tr>";
                echo "<td>". $product->id . "</td>";
                echo "<td>". $product->name . "</td>";
                echo "<td>". $product->price . "</td>";
                echo "<td>". $product->fecha_compra . "</td>";
                echo "<td><a href='/Product/Show/" . $product->id . "'>Detalles</a></td>";
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