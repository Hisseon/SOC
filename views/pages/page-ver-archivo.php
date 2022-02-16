<?php
ob_clean(); //Limpiamos el buffer de informacion previa
if (isset($_GET["file"])) {
    $nombreDeArchivo = $_GET['file'];
    $nombreDeArchivo = basename($nombreDeArchivo);
    header('Content-Description: File Transfer');
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=$nombreDeArchivo");
    readfile("assets/archivos/" . $nombreDeArchivo);
    exit; //Evitamos que se mande informacion posterior
} elseif (isset($_GET["xml"])) {
    $nombreDeArchivo = $_GET['xml'];
    $nombreDeArchivo = basename($nombreDeArchivo);
    $xml = file_get_contents('assets/archivos/' . $nombreDeArchivo);
    header('Content-type: application/xml');
    header("Content-Disposition: attachment; filename=$nombreDeArchivo");
    echo $xml;
    exit;
}