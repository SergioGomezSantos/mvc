<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Delete</title>
</head>
<body>
    
    <!-- Cabecera -->
    <?php require "header.php" ?>

    <!-- Formulario -->
    <form id="listForm" name="form" action="/agenda/checkDelete" method="POST">
    
        <br>
        <h3 id="listTitle">Contacto a Eliminar: </h3>
        <select id="listContatc" name="removeContatc">
        
            <?
                // Recorro los contactos para crear una lista de opciones para el select con value|text = id|nombre de cada contacto
                foreach ($contacts as $contact) {
                    
                    echo '<option value=' . $contact["id"] . '>' . $contact["nombre"] . '</option>';
                }
            ?>

        </select>

        <button type="submit" name="deleteSend" id="oneLineSend" value="deleteSend">Eliminar</button>

    </form>

    <!-- Divs de ok/error -->
    <? require "infoDivs.php" ?>

</body>
</html>