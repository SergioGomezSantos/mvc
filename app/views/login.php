<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Log In</title>
</head>

<body>

    <? require "header.php" ?>

    <div>
        <br>
        <? 
            if ($exist) {
                echo "<p>La tabla credenciales ya existe.</p>";
            } else {
                echo "<p>La tabla credenciales todavía no existe.</p>";
            }
        ?>
    </div>

    <?
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

    <? 
        require "infoDivs.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>