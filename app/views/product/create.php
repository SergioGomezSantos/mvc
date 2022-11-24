<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">
    <title>Create</title>
</head>

<body>

    <div>
        <h1>Alta de usuario</h1>
    </div>
    
    <div>
        <form method="post" action="/Product/store">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group">
                <label>Precio</label>
                <input type="text" name="price" class="form-control">
            </div>
            <div class="form-group">
                <label>Fecha Compra</label>
                <input type="text" name="fecha_compra" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">Enviar</button>
        </form>
    </div>

    <br><hr>

    <?php
    require "footer.php";
    redirectHome();
    ?>

</body>

</html>