<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Insert</title>
</head>

<body>

    <!-- Cabecera -->
    <?php require "header.php" ?>

    <!-- Formulario -->
    <form name="form" action="/agenda/checkInsert" method="POST">

        <h3>Crear un Contacto: </h3>

        <!-- Formulario Básico Reutilizable -->
        <? require "basicForm.php" ?>

        <button type="submit" name="send" id="inputSend" value="send">Insertar</button>
    </form>

    <!-- Divs ok/error + unset PrevForm al terminar para limpiar -->
    <? 
        require "infoDivs.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>