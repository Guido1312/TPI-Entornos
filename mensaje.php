<?php
if (isset($vMensaje) && isset($vTipoMensaje)){
    ?>
    <div class="alert alert-<?php echo($vTipoMensaje)?> alert-dismissible fade show" role="alert">
    <?php echo($vMensaje)?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
    </div>
<?php
}
elseif (isset($vMensaje)){
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo($vMensaje)?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
    </div>
<?php
}
?>

