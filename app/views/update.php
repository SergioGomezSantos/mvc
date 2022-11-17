<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Update</title>
</head>
<body>
    
    <?php require "header.php" ?>

    <form id="listForm" name="form" action="/agenda/checkUpdateSelected" method="POST">
    
        <br>
        <h3 id="listTitle">Contacto a Actualizar: </h3>
        <select id="listContatc" name="updateContatc">
        
            <?
                foreach ($contactsName as $contactName) {
                    echo '<option value=' . $contactName . '>' . $contactName . '</option>';
                }
            ?>

        </select>

        <button type="submit" name="updateSend" id="updateSend" value="updateSend">Actualizar</button>

    </form>

    <? 
        require "infoDivs.php";
    ?>

</body>
</html>