<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Search</title>
</head>

<body>

    <?php require "header.php" ?>

    <form name="form" action="" method="GET">

        <h3>Contacto: </h3>

        <? require "basicForm.php" ?>

    </form>

    <? 
        require "infoDivs.php";
        require "footer.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>