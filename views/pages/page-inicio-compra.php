<?php
include 'barComprador.php';
$inst = new ControladorFormularios;
?>

<main class="app-content">
    <div class="app-title" style="padding-top: 35px; padding-bottom:20px">
        <div>
            <h1><i class="fa fa-home"></i> Inicio</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio-compra"><i class="fa fa-home fa-lg"></i></a></li>
        </ul>
    </div>
    <div class="tile">
        <div class="tile-title">
            ÓRDENES DE COMPRA - PENDIENTES DE APROBACIÓN
        </div>
        <div class="tile-body text-center">
            <table id="suppTab" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">ID PO</th>
                        <th scope="col">Comprador</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Ver PO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($inst->obtnHistorialPendientesAprobacion() as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value["idPo"] ?></td>
                            <td><?php echo $value["nombre"] . " " . $value["apellido"] ?></td>
                            <td><?php echo $value["nombreComercial"] ?></td>
                            <td><?php echo $value["fechaPo"] ?></td>
                            <td><?php echo $value["total"] . " " . $value["divisa"] ?></td>
                            <td><span class="estatus pendiente"><?php echo $value["estatus"] ?></span></td>
                            <td class="col-sm-1">
                                <a class="btn btn-primary btn-sm" href="index.php?pagina=page-po-details&id=<?php echo $value["idPo"] ?>">
                                    <i class="fa fa-eye fa-lg" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tile">
        <div class="tile-title">
            ÓRDENES DE COMPRA - PENDIENTES DE FACTURA
        </div>
        <div class="tile-body text-center">
            <table id="suppTab" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col">ID PO</th>
                        <th scope="col">Comprador</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Subir factura</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($inst->obtnHistorialPendientesFactura() as $key => $value) : ?>
                        <tr>
                            <td><?php echo $value["idPo"] ?></td>
                            <td><?php echo $value["nombre"] . " " . $value["apellido"] ?></td>
                            <td><?php echo $value["nombreComercial"] ?></td>
                            <td><?php echo $value["fechaPo"] ?></td>
                            <td><?php echo $value["total"] . " " . $value["divisa"] ?></td>
                            <td><span class="estatus aprobado"><?php echo $value["estatus"] ?></span></td>
                            <td class="col-sm-1">
                                <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#modalFactura<?php echo $value["idPo"] ?>">
                                    <i class="fa fa-file-upload fa-lg"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="modalFactura<?php echo $value["idPo"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Subir archivos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group row" style="align-items: center;">
                                                <label class="control-label col-md-2" for="invoice">Factura</label>
                                                <div class="col-md-auto">
                                                    <input class="form-control p-1" type="file" name="invoice" id="invoice">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="align-items: center;">
                                                <label class="control-label col-md-2" for="xml">XML</label>
                                                <div class="col-md-auto">
                                                    <input class="form-control p-1" type="file" name="xml" id="xml">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="align-items: center;">
                                                <div class="col-md-12" style="text-align: center;">
                                                    <span>o</span>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="align-items: center;">
                                                <label class="control-label col-md-2" for="fecha">Fecha de facturación</label>
                                                <div class="col-md-8">
                                                    <input class="form-control" style="width: 21em;" type="date" name="fecha" id="fecha">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-secondary w-25 mr-3" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary w-25">Guardar</button>
                                        </div>
                                        <input class="form-control" type="text" name="idPO" id="idPO" value="<?php echo $value["idPo"] ?>" hidden>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php
if (!empty($_POST)) {
    if (!empty($_FILES["invoice"]["name"]) && (!empty($_FILES["xml"]["name"]) || !empty($_POST["fecha"]))) {
        $inst->ctrUpdateFactura();
    } else {
        echo '<script> alert("Revisa los campos, por favor") </script>';
    }
}
?>