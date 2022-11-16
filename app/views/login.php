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

    <form name="form" action="/login/check" method="POST" id="loginForm">

        <label for="userName">Usuario: </label>
        <input type="text" name="userName" id="loginUserName" value="<?= $_SESSION['prevForm']['prevUsername'] ?>" />
        <br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="loginPassword" />
        <br>

        <button type="submit" name="send" id="loginSend" value="send">Enviar</button>
    </form>

    <? 
        require "infoDivs.php";
        unset ($_SESSION['prevForm']);
    ?>

</body>

</html>