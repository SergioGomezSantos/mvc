<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <title>Document</title>
</head>

<body>

    <div>
        <h1>Edición de usuario</h1>
    </div>

    <div>
        <form method="post" action="/product/update">
            <input type="hidden" name="id" value="<?php echo $product->id ?>">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" value="<?php echo $product->name ?>">
            </div>
            <div class="form-group">
                <label>Precio</label>
                <input type="text" name="price" class="form-control" value="<?php echo $product->price ?>">
            </div>
            <div class="form-group">
                <label>Fecha Compra</label>
                <input type="text" name="fecha_compra" class="form-control" value="<?php echo $product->fecha_compra->format('d-m-Y') ?>">
            </div>
            <button type="submit" class="btn btn-default">Enviar</button>
        </form>

        <br><br><hr>

        <?php
        require "footer.php";
        redirectHome();
        ?>

    </div>
</body>

</html>