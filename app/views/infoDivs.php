<div id="divError">
    <?= $_SESSION['error'] ?>
</div>

<div id="divOK">
    <?= $_SESSION['ok'] ?>
</div>

<? 
    unset ($_SESSION['ok']);
    unset ($_SESSION['error']);
?>