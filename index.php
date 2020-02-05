<?php

require_once 'app-start.php';
require_once 'util.php';
print_r($_POST);

if (isset($_POST['val'])) {
    $res = calculate($_POST['val']);
    if (isnum($res)) {

    } else {

    }
}

?>

<?php require SITE_ROOT . 'master-page/Header/header.php'; ?>

<form method="post" action="./index.php" class="_flex-centering column calc-container">
    <div class="output"><?= isset($_POST['val']) ? calculate($_POST['val']) : '0' ?></div>
    <div><input type="text" class="input-field" name="val" pattern="[\d\.+-*/\:]*"></div>
    <div><input type="submit" class="resolve-button" value="Resolve"></div>

</form>

<script>
    document.querySelector('.input-field').focus();
</script>

<?php require SITE_ROOT . 'master-page/Footer/footer.php' ?>

