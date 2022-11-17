<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Update Selected</title>
</head>
<body>
    
    <?php require "header.php" ?>

    <form name="form" action="/agenda/updateSelected" method="POST">
    
        <h3>Actualizar un Contacto: </h3>

        <? require "basicForm.php" ?>

        <button type="submit" name="updateSend" id="updateSend" value="updateSend">Actualizar</button>

    </form>

    <? 
        require "infoDivs.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>
</html>