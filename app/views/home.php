<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Home</title>
</head>

<body>

    <?php require "header.php" ?>

    <div>
        <br>
        <? 
            if ($exist) {

                echo "<p>La tabla Contactos Trabajo ya existe.</p>";
            } else {
                
                echo "<p>La tabla Contactos Trabajo todavía no existe.</p>";
            }
        ?>
    </div>

    <?
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

    <?php require "infoDivs.php" ?>
    
</body>

</html>