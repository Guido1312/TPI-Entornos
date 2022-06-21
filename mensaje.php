<?php
if (isset($vMensaje) && isset($vTipoMensaje)){
    ?>
    <div class="alert alert-<?php echo($vTipoMensaje)?>" role="alert">
    <?php echo($vMensaje)?>
    </div>
<?php
}
elseif (isset($vMensaje)){
    ?>
    <div class="alert alert-warning" role="alert">
    <?php echo($vMensaje)?>
    </div>
<?php
}
?>

