<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Log In</title>
</head>

<body>

    <!-- Cabecera -->
    <? require "header.php" ?>

    <!-- Div Información -->
    <div>
        <br>
        <? 
            // Muestro un texto informativo según exista o no la tabla Credenciales

            if ($exist) {

                echo "<p>La tabla credenciales ya existe.</p>";

            } else {

                echo "<p>La tabla credenciales todavía no existe.</p>";
            }
        ?>
    </div>

    <!-- Formulario -->
    <?
        // Muestro el formulario de login o un botón (formulario) para inicializar la tabla según exista o no la tabla Credenciales

        if ($exist) {

            require "loginForm.php";

        } else {

            echo '
                <form action="/login/initialize">
                    <input type="submit" value="Iniciar Tabla" id="initializeTable" />
                </form>
            ';
        }
    ?>

        <br><br>

    <!-- Divs ok/error + unset PrevForm al terminar para limpiar -->
    <? 
        require "infoDivs.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>