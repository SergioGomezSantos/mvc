<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Update Selected</title>
</head>

<body>

    <!-- Cabecera -->
    <?php require "header.php" ?>

    <!-- Formulario -->
    <form name="form" action="/agenda/updateSelected" method="POST" enctype="multipart/form-data">

        <h3>Actualizar un Contacto: </h3>

        <!-- Formularaio Básico Reutilizable -->
        <? require "basicForm.php" ?>

        <!-- Imagen. Muestra un text en readonly con el nombre del archivo actual y una opción para actualizarlo -->
        <br>
        <label for='image'>Imagen: </label>
        <input type='text' name='image' id='inputImage' value='<?= $_SESSION['prevForm']['prevImage'] ?>' readonly />
        <br>

        <label id="labelFile" for="file">Nueva: </label>
        <input type="file" name="file" id="inputFile2"/>
        <br>

        <button type="submit" name="updateSend" id="updateSend" value="updateSend">Actualizar</button>

    </form>

    <!-- Divs ok/error + Footer (volver) + unset PrevForm al terminar para limpiar -->
    <? 
        require "infoDivs.php";
        require "footer.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>