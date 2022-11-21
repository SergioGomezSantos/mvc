
<!-- Formulario que reutilizo en insert y en update/search ya sea vacío o con los valores anteriores/encontrados -->

<label for="type">Tipo: </label>
<select id="inputType" name="type">

    <? 
        // Si existe readonly (viene de search), solo aparece una opción (prevType) para que no se pueda modificar
        // Si prevType, pongo selected en el tipo correspondiente y añado la otra opción
        // Si ninguna, muestro ambas opciones sin ningún añadido

        if ($readonly) {

            echo "<option>" . ucwords($_SESSION['prevForm']['prevType']) . "</option>";

        } elseif ($_SESSION['prevForm']['prevType'] === 'persona') {

            echo "<option value='persona' selected >Persona</option>";
            echo "<option value='empresa' >Empresa</option>";

        } elseif ($_SESSION['prevForm']['prevType'] === 'empresa') {

            echo "<option value='persona' >Persona</option>";
            echo "<option value='empresa' selected >Empresa</option>";

        } else {

            echo "<option value='persona' >Persona</option>";
            echo "<option value='empresa' >Empresa</option>";
        }
    ?>

</select>

<!-- Formulario Base. 
     Cuando no existe prevForm, no rellenará con nada 
     Cuando no exista $readonly, no lo pondrá
     Campo hidden con la id para poder usarlo al hacer update con los cambios
-->

<br>
<label for="name">Nombre: </label>
<input type="text" name="name" id="inputName" value="<?= $_SESSION['prevForm']['prevName'] ?>" <?= $readonly ?> />
<br>
<label for="surnames">Apellidos: </label>
<input type="text" name="surnames" id="inputSurnames" value="<?= $_SESSION['prevForm']['prevSurnames'] ?>" <?= $readonly ?> />
<br>
<label for="address">Dirección: </label>
<input type="text" name="address" id="inputAddress" value="<?= $_SESSION['prevForm']['prevAddress'] ?>" <?= $readonly ?> />
<br>
<label for="phone">Teléfono: </label>
<input type="number" name="phone" id="inputPhone" value="<?= $_SESSION['prevForm']['prevPhone'] ?>" <?= $readonly ?> />
<br>
<label for="email">Email: </label>
<input type="email" name="email" id="inputEmail" value="<?= $_SESSION['prevForm']['prevEmail'] ?>" <?= $readonly ?> />
<br>

<input type="hidden" value="<?= $_SESSION['prevForm']['id'] ?>" id="id" name="id">