<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Search</title>
</head>

<body>

    <!-- Cabecera -->
    <?php require "header.php" ?>

    <!-- Formulario -->
    <form name="form" action="" method="GET">

        <h3>Contacto: </h3>

        <!-- Formulario Básico Reutilizable -->
        <? require "basicForm.php" ?>

    </form>

    <!-- Divs ok/error + Footer para volver + unset PrevForm al terminar para limpiar -->
    <? 
        require "infoDivs.php";
        require "footer.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>