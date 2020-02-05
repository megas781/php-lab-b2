<?php

require_once 'app-start.php';
require_once 'util.php';

session_start();
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

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

    <? if (sizeof($_SESSION['history']) > 0): ?>
    <h4>Computing history</h4>
    <div class="history">
        <table>
            <? for ($i = sizeof($_SESSION['history'])-1; $i >= 0; $i--):?>
            <tr>
                <style>
                    .history td {
                        padding: 4px 8px;
                    }
                </style>
                <td><?=$i + 1?>)</td>
                <td><?= $_SESSION['history'][$i][0]?></td>
                <td>=</td>
                <td><?=$_SESSION['history'][$i][1]?></td>
            </tr>
            <? endfor; ?>
        </table>
    </div>
    <? endif; ?>
    <?
    if (isset($_POST['val'])) {
        array_push($_SESSION['history'], [$_POST['val'], $res]);
    }
    ?>
</form>

<script>
    document.querySelector('.input-field').focus();
</script>

<?php require SITE_ROOT . 'master-page/Footer/footer.php' ?>

