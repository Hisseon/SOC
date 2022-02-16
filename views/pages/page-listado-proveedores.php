<?php
include 'barAdmin.php';
$inst = new ControladorFormularios;
?>

<main class="app-content">
  <div class="app-title" style="padding-top: 35px; padding-bottom:20px">
    <div>
      <h1><i class="fa fa-edit"></i> Listado de Proveedores</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio"><i class="fa fa-home fa-lg"></i></a></li>
      <li class="breadcrumb-item"><a href="index.php?pagina=page-listado-proveedores">Listado de Proveedores</a></li>
    </ul>
  </div>
  <div class="tile text-center">
    <div class="tile-title">
      <div class="row justify-content-end">
        <div class="mr-3">
          <a class="btn btn-primary" href="index.php?pagina=page-proveedor">Dar de alta proveedor</a>
        </div>
      </div>
    </div>
    <div class="tile-body">
      <table id="suppTab" class="table table-striped table-bordered" style="width: 100%;">
        <thead>
          <tr>
            <th scope="col">Nombre Comercial</th>
            <th scope="col">Correo</th>
            <th scope="col">Número Cliente</th>
            <th scope="col">Dirección</th>
            <th scope="col">Ciudad</th>
            <th scope="col">Estado</th>
            <th scope="col">CP</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Archivos</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($inst->obtnProveedores() as $key => $value) : ?>
            <tr>
              <td><?php echo $value["nombreComercial"] ?></td>
              <td><?php echo $value["correo"] ?></td>
              <td><?php echo $value["numeroCliente"]?></td>
              <td><?php echo $value["direccion"] ?></td>
              <td><?php echo $value["ciudad"] ?></td>
              <td><?php echo $value["estado"] ?></td>
              <td><?php echo $value["codigoPostal"] ?></td>
              <td><?php echo $value["numeroTel"] ?></td>
              <td></td>
              <td>
                <a class="btn btn-danger btn-sm" href="index.php?pagina=delete&id=<?php echo $value["idSupplier"] ?>">
                  <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</main>