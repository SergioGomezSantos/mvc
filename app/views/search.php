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

    <form id="listForm" name="form" action="" method="GET">

        <br>
        <h3 id="listTitle">Contacto a Buscar: </h3>
        <select id="listContatc" name="contact">

            <?
                foreach ($contacts as $contact) {
                    echo '<option value=' . $contact["id"] . '>' . $contact["nombre"] . '</option>';
                }
            ?>

        </select>

        <button type="submit" id="oneLineSend">Buscar</button>

    </form>

    <? 
        require "infoDivs.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>