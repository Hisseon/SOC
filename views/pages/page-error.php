<?php
//Comprueba el rol para cargar las funciones de comprador o administrador. Usar este código en funciones que
//comparten ambos roles.
if ($_SESSION['rol'] == "Comprador")
    include 'barComprador.php';
else
    include 'barAdmin.php';
?>

<main class="app-content">
      <div class="page-error tile">
        <h1><i class="fa fa-exclamation-circle"></i> Error 404: Page not found</h1>
        <p>The page you have requested is not found.</p>
        <p><a class="btn btn-primary" href="javascript:window.history.back();">Go Back</a></p>
      </div>
    </main>