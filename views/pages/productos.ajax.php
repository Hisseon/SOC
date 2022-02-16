<?php

require_once "../controllers/plantilla.controlador.php";
require_once "../models/formularios.modelo.php";

class AjaxProducts {

    public $imageMultimedia;
    public $rutaMultimedia;

    public function ajaxSubirImagenes() {
        $datos = $this->imageMultimedia;
        $ruta = $this->rutaMultimedia;

        $respuesta = ControladorPlantilla::crtSubirImagenes($datos, $ruta);

        echo $respuesta;
    }

    public $tituloproducto;
    public $multimedia;

    public function ajaxCrearProducto() {
        $datos = array(
            "tituloProdcuto" => $this->tituloproducto,
            "multimedia" => $this->multimedia
        );
        $respuesta = ControladorPlantilla::crtCrearProducto($datos);

        echo $respuesta;
    }

}

if (isset($_FILES["file"])) {
    $multimedia = new AjaxProducts();
    $multimedia->imageMultimedia = $_FILES["file"];
    $multimedia->rutaMultimedia = $_POST["ruta"];
    $multimedia->ajaxSubirImagenes();
}

if (isset($_POST["tituloProducto"])) {
    $producto = new AjaxProducts();
    $producto->tituloproducto = $_POST["tituloProducto"];
    $producto->multimedia = $_POST["multimedia"];
    $producto->ajaxCrearProducto();
}

