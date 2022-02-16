<?php
if (isset($_GET["id"])){
    $delete = new ControladorFormularios;
    $delete -> dltProveedor();
}
if (isset($_GET["idPO"])){
    $delete = new ControladorFormularios;
    $delete -> dltPO();
}
if (isset($_GET["idUsuario"])){
    $delete = new ControladorFormularios;
    $delete -> dltUsuario();
}

?>