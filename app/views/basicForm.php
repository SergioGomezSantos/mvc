<label for="type">Tipo: </label>
<select id="inputType" name="type">

    <? 
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