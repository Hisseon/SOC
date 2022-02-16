<?php
include 'barAdmin.php';
$inst = new ControladorFormularios;
$data = $inst->obtnHistorialPendientesPago();
?>

<main class="app-content">
    <div class="app-title" style="padding-top: 35px; padding-bottom:20px">
        <div>
            <h1><i class="fa fa-home"></i> Inicio</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio"><i class="fa fa-home fa-lg"></i></a></li>
        </ul>
    </div>
    <div class="tile">
        <div class="tile-title">
            ÓRDENES DE COMPRA - PENDIENTES DE APROBACIÓN
        </div>
        <div class="tile-body text-center">
            <table class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" width="63px">ID PO</th>
                        <th scope="col">Comprador</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Acciones</th>
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
        <div class="row justify-content-between">
            <div class="col-auto">
                <div class="tile-title">
                    ÓRDENES DE COMPRA - PENDIENTES DE PAGO
                </div>
            </div>
            <div class="col-auto">
                <form id="excel" method="POST" action="views/pages/exportData.php" onsubmit="return validation();">
                    <button type="submit" class="btn btn-primary">Exportar seleccionados</button>
                </form>
            </div>
        </div>
        <div class="tile-body text-center">
            <table id="tabla" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th>ID PO</th>
                        <th>No. Factura</th>
                        <th>Comprador</th>
                        <th>Proveedor</th>
                        <th>Fecha de Pago</th>
                        <th>Total</th>
                        <th>Subir pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($inst->obtnHistorialPendientesPago() as $key => $value) : ?>
                        <tr>
                            <td> <input type="checkbox" class="idExport" name="idExport[]" id="idExport" value="<?php echo $value["idPo"] ?>" form="excel"> </td>
                            <td><?php echo $value["idPo"] ?></td>
                            <td><?php echo $value["idInvoice"] ?></td>
                            <td><?php echo $value["nombre"] . " " . $value["apellido"] ?></td>
                            <td><?php echo $value["nombreComercial"] ?></td>
                            <td>
                                <?php echo $value["fechaPago"] ?>&nbsp;&nbsp;
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Date<?php echo $value["idPo"] ?>">
                                    <i class="fa fa-edit fa-lg"></i>
                                </button>
                            </td>
                            <td><?php echo $value["total"] . " " . $value["divisa"] ?></td>
                            <td class="col-sm-1">
                                <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#exampleModalCenter<?php echo $value["idPo"] ?>">
                                    <i class="fa fa-file-upload fa-lg"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter<?php echo $value["idPo"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Subir comprobante de pago</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group row" style="align-items: center;">
                                                <label class="control-label col-md-auto" for="invoice">Comprobante de pago</label>
                                                <div class="col-md-auto">
                                                    <input class="form-control p-1" type="file" name="pago" id="pago">
                                                    </input>
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

                        <!-- Modal -->
                        <div class="modal fade" id="Date<?php echo $value["idPo"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Actualizar fecha de pago</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <div class="form-group row" style="align-items: center;">
                                                <label class="control-label col-md-auto" for="fecha">Fecha de pago</label>
                                                <div class="col-md-auto">
                                                    <input class="form-control p-1" type="date" name="fecha" id="fecha">
                                                    </input>
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

<script>
    function validation() {
        var valid;
        var rows = document.getElementById("tabla").rows.length;
        for (let index = 0; index < rows - 1; index++) {
            valid = document.getElementsByClassName("idExport")[index].checked;
            console.log(valid);
            if (valid)
                return true;
        }
        return false;
    }
</script>

<?php
if (!empty($_POST["fecha"])){
    $inst -> ctrActualizarFechaPago();
}
if (!empty($_FILES)) {
    $inst->ctrUpdatePago();
}
?>