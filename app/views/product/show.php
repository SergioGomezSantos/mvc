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
                <td><b>Id</b></td>
                <td><b>Name</b></td>
                <td><b>Price</b></td>
                <td><b>Fecha_Compra</b></td>
            </tr>

            <?php

                echo "<tr>";

                if ($product) {

                    echo "<tr>";
                    echo "<td>". $product->id . "</td>";
                    echo "<td>". $product->name . "</td>";
                    echo "<td>". $product->price . "</td>";
                    echo "<td>". $product->fecha_compra->format('d-m-Y') . "</td>";
                    echo "</tr>";

                } else {

                    echo "<td>#</td>";
                    echo "<td>#</td>";
                    echo "<td>#</td>";
                    echo "<td>#</td>";
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