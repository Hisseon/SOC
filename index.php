<?php
#EN EL INDEX mostraremos la salida de las vistas al usuario y tambien a traves de el enviaremos las distintas acciones que el usuario envie al controlador.
#require establece que el codigo del archivo invocado es requerido, es decir, obligatorio para el funcionamiento del programa. Por ello si el archivo especificado en la funcion require() no se encuentra saltará un error "PHP Fatal error" y el programa PHP se detendrá.
#require_once funciona de la misma forma que sus respectivo, salvo que al utilizar la version _once, se impide la carga de un mismo archivo mas de una vez.
#si requerimos el mismo codido mas de una vez corremos el riesgo de redeclaraciones de variables, funciones o clases.
require_once "assets/dompdf/autoload.inc.php";
require_once "controllers/plantilla.controlador.php";
require_once "controllers/formularios.controlador.php";
require_once "models/formularios.modelo.php";
$plantilla = new controladorPlantilla();
$plantilla -> ctrTraerPlantilla();
