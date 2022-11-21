<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Home</title>
</head>

<body>

    <!-- Cabecera -->
    <?php require "header.php" ?>

    <!-- Div Información -->
    <div>
        <br>
        <? 
            // Muestro un texto informativo según exista o no la tabla Contacos

            if ($exist) {

                echo "<p>La tabla Contactos Trabajo ya existe.</p>";

            } else {
                
                echo "<p>La tabla Contactos Trabajo todavía no existe.</p>";
            }
        ?>
    </div>

    <!-- Formulario Initialize/Reset -->
    <?
        // Muestro un botón (formulatio) según exista o no la tabla Contactos para inicializar/resetear la tabla

        if ($exist) {

            echo '
                <form action="/agenda/reset">
                    <input type="submit" value="Resetear Valores" id="resetTable" />
                </form>
            ';

        } else {

            echo '
                <form action="/agenda/initialize">
                    <input type="submit" value="Iniciar Tabla" id="initializeTable" />
                </form>
            ';
        }
    ?>

    <!-- Divs ok/error -->
    <?php require "infoDivs.php" ?>
    
</body>

</html>