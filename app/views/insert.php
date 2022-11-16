<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Insert</title>
</head>

<body>

    <?php require "header.php" ?>

    <form name="form" action="/agenda/checkInsert" method="POST">

        <h3>Crear un Contacto: </h3>

        <label for="type">Tipo: </label>
        <select id="insertType" name="type">
            <option value="persona" <? if($_SESSION['prevForm']['prevType'] === 'persona') {echo 'selected' ;} ?> >Persona</option>
            <option value="empresa" <? if($_SESSION['prevForm']['prevType'] === 'empresa') {echo 'selected' ;} ?>>Empresa</option>
        </select>
        <br>
        <label for="name">Nombre: </label>
        <input type="text" name="name" id="insertName" value="<?= $_SESSION['prevForm']['prevName'] ?>" />
        <br>
        <label for="surnames">Apellidos: </label>
        <input type="text" name="surnames" id="insertSurnames" value="<?= $_SESSION['prevForm']['prevSurnames'] ?>" />
        <br>
        <label for="address">Dirección: </label>
        <input type="text" name="address" id="insertAddress" value="<?= $_SESSION['prevForm']['prevAddress'] ?>" />
        <br>
        <label for="phone">Teléfono: </label>
        <input type="number" name="phone" id="insertPhone" value="<?= $_SESSION['prevForm']['prevPhone'] ?>" />
        <br>

        <button type="submit" name="send" id="insertSend" value="send">Enviar</button>
    </form>

    <? 

    require "infoDivs.php";

    unset ($_SESSION['prevForm']);

    ?>

</body>

</html>