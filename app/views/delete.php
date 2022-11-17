<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Delete</title>
</head>
<body>
    
    <?php require "header.php" ?>

    <form id="listForm" name="form" action="/agenda/checkDelete" method="POST">
    
        <br>
        <h3 id="listTitle">Contacto a Eliminar: </h3>
        <select id="listContatc" name="removeContatc">
        
            <?
                foreach ($contactsName as $contactName) {
                    echo '<option value=' . $contactName . '>' . $contactName . '</option>';
                }
            ?>

        </select>

        <button type="submit" name="deleteSend" id="deleteSend" value="deleteSend">Eliminar</button>

    </form>

    <? 
        require "infoDivs.php";
    ?>

</body>
</html>