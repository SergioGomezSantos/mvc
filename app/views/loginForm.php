<form name="form" action="/login/check" method="POST" id="loginForm">

<label for="userName">Usuario: </label>
<input type="text" name="userName" id="loginUserName" value="<?= $_SESSION['prevForm']['prevUsername'] ?>" />
<br>
<label for="password">Password: </label>
<input type="password" name="password" id="loginPassword" />
<br>

<button type="submit" name="send" id="loginSend" value="send">Enviar</button>
</form>