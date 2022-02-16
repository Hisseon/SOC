<?php
if ($_SESSION['rol'] == "Comprador") {
    $link = '-compra';
    include 'barComprador.php';
} else {
    include 'barAdmin.php';
    $link = '';
}
$inst = new ControladorFormularios;
$value = $inst->obtnDetallesPO();
$IVA = 0;
$subtotal = $value[0]['total'];
if ($value[0]['IVA'] == "SI") {
    $subtotal = $value[0]['total'] / 1.1600;
    $IVA = $value[0]['total'] - $subtotal;
}
?>

<main class="app-content">
    <div class="app-title" style="padding-top: 35px; padding-bottom: 20px">
        <div>
            <h1><i class="fa fa-file-alt"></i> Detalles PO</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio<?php echo $link ?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="index.php?pagina=page-po-details&id=<?php echo $_GET["id"] ?>">Detalles PO <?php echo $_GET["id"] ?></a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Información de proveedor</h3>
                <div class="tile-body">
                    <form class="form-horizontal" method="POST">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group row" style="align-items: center;">
                                    <label class="control-label col-md-auto" for="proveedor">Proveedor</label>
                                    <div class="col">
                                        <input class="form-control" style="height: 35px;" name="proveedor" id="proveedor" value="<?php echo $value[0]["nombreComercial"] ?>" disabled>
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group row" style="align-items: center;">
                                    <label for="cotizacion" class="control-label col-md-auto">Cotización</label>
                                    <div class="col">
                                        <a class="btn btn-primary" href="index.php?pagina=page-ver-archivo&file=<?php echo $value[0]["cotización"] ?>" target="_blank"> Ver cotización </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-group row" style="align-items: center;">
                                    <label class="control-label col-md-auto" for="divisa">Divisa</label>
                                    <div class="col">
                                        <input class="form-control" style="height: 35px;" name="divisa" id="divisa" value="<?php echo $value[0]["divisa"] ?>" disabled>
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-between" style="align-items: center;">
                                    <label class="control-label col-md-auto" for="IVA">IVA</label>
                                    <div class="col-auto">
                                        <input class="form-control" style="height: 35px;" name="IVA" id="IVA" value="<?php echo $value[0]["IVA"] ?>" disabled>
                                        </input>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3>Productos</h3>
                        </div>
                        <table id="tabla" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ITEM NUMBER</th>
                                    <th>DESCRIPTION 1</th>
                                    <th>DESCRIPTION 2</th>
                                    <th>DELIVERY DATE</th>
                                    <th>QUANTITY ORDERED</th>
                                    <th>UOM</th>
                                    <th>UNIT COST</th>
                                    <th>EXTENDED PRICE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($inst->obtnDetallesPO() as $key => $value) : ?>
                                    <tr class="fila-fija">
                                        <td>
                                            <?php echo $value["itemNumber"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["description1"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["description2"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["deliveryDate"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["quantity"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["UOM"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["unitCost"] ?>
                                        </td>
                                        <td>
                                            <?php echo $value["extendedPrice"] ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <input type="text" class="form-control" name="totalPO" id="totalPO" hidden>

                </div>
                <br>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <h3>Comentarios adicionales</h3>
                        <textarea class="form-control" name="comments" id="comments" rows="3" disabled><?php echo $value["otherComments"] ?></textarea>
                    </div>
                    <div class="col-auto">
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <h6>Discount(%)</h6>
                                <input type="number" class="form-control col-md-auto" name="descuento" min="0" max="100" id="descuento" value="0" onchange="suma(this)" onkeyup="suma(this)" disabled>
                            </div>
                            <div class="col-auto text-right">
                                <h5>Subtotal amount: <br>
                                    Discount amount: <br>
                                    VAT amount: <br>
                                    Total amount:
                                </h5>
                            </div>
                            <div class="col-auto text-right">
                                <h5><span id="subtotal"></span><?php echo number_format($subtotal, 4) ?><br>
                                    <span id="discount"></span>-<br>
                                    <span id="vat"></span><?php echo number_format($IVA, 4) ?><br>
                                    <span id="total"><?php echo number_format($value['total'], 4) ?></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($_SESSION["rol"] == "Admin" && ($value["estatus"] != "APROBADO"))
                    echo
                    '<div class="row justify-content-center">
                    <div class="col-md-3 text-center">
                        <h3>Motivo</h3>
                        <textarea class="form-control col-md-auto" name="motivo" id="motivo" rows="3"></textarea>
                    </div>
                </div>
                <div class="tile-footer">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                        <button class="btn btn-success" type="submit" name="estatus" id="estatus" value="APROBADO"><i class="fa fa-fw fa-lg fa-check-circle"></i>Aprobar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="submit" name="estatus" id="estatus" value="RECHAZADO"><i class="fa fa-fw fa-lg fa-check-circle"></i>Rechazar</button>                        </div>
                    </div>
                </div>'
                ?>
                </form>
            </div>
        </div>
    </div>
    </div>
</main>

<?php
if (!empty($_POST)) {
    $estatus = new ControladorFormularios;
    $estatus->ctrActualizarEstatusPO();
}
