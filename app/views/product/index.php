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
                <td><b>Edit</b></td>
                <td><b>Delete</b></td>
            </tr>

            <?php
            foreach ($products as $product) {

                echo "<tr>";
                echo "<td>". $product->id . "</td>";
                echo "<td>". $product->name . "</td>";
                echo "<td>". $product->price . "</td>";
                echo "<td>". $product->fecha_compra->format('d-m-Y') . "</td>";
                echo "<td><a href='/Product/Show/" . $product->id . "'>Detalles</a></td>";
                echo "<td><a href='/Product/Edit/" . $product->id . "'>Edit</a></td>";
                echo "<td><a href='/Product/Delete/" . $product->id . "'>Delete</a></td>";
                echo "</tr>";

            }
            ?>
        </table>
    </div>

    <br>
    <hr>
    
    <?php 
    require "footer.php";
    fromIndex();
    ?>

</body>

</html>