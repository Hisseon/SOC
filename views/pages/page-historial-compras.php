<?php
//Comprueba el rol para cargar las funciones de comprador o administrador. Usar este código en funciones que
//comparten ambos roles.
if ($_SESSION['rol'] == "Comprador") {
    $link = '-compra';
    include 'barComprador.php';
} else {
    include 'barAdmin.php';
    $link = '';
}
$inst = new ControladorFormularios;
?>

<main class="app-content">
    <div class="app-title" style="padding-top: 35px; padding-bottom:20px">
        <div>
            <h1><i class="fa fa-edit"></i> Historial de compras</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio<?php echo $link ?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="index.php?pagina=page-historial-compras">Historial de compras</a></li>
        </ul>
    </div>
    <div class="tile text-center">

        <div class="tile-body">
            <table id="suppTab" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                    <tr>
                        <th scope="col" width="63em" style="vertical-align: middle;">ID PO</th>
                        <th scope="col" style="vertical-align: middle;">Comprador</th>
                        <th scope="col" style="vertical-align: middle;">Proveedor</th>
                        <th scope="col" style="vertical-align: middle;">Fecha</th>
                        <th scope="col" style="vertical-align: middle;">Fecha de Pago</th>
                        <th scope="col" width="203em" style="vertical-align: middle;">Archivos</th>
                        <th scope="col" style="vertical-align: middle;">Estatus</th>
                        <th scope="col" style="vertical-align: middle;">Motivo</th>
                        <th scope="col" style="vertical-align: middle;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($inst->obtnHistorial() as $key => $value) : ?>
                        <tr>
                            <td style="vertical-align: middle;"><?php echo $value["idPo"] ?></td>
                            <td style="vertical-align: middle;"><?php echo $value["nombre"] . " " . $value["apellido"] ?></td>
                            <td style="vertical-align: middle;"><?php echo $value["nombreComercial"] ?></td>
                            <td style="vertical-align: middle;"><?php echo $value["fechaPo"] ?></td>
                            <td style="vertical-align: middle;"><?php echo $value["fechaPago"] ?></td>
                            <td style="vertical-align: middle;"> <a class="btn btn-primary mr-1" href="index.php?pagina=page-ver-archivo&file=<?php echo $value["cotización"] ?>" target="_blank">Cotización</a>
                                <?php if (isset($value["factura"])) echo '<a class="btn btn-primary" href="index.php?pagina=page-ver-archivo&file=' . $value["factura"] . '" target="_blank">Factura</a>' ?>
                                <br>
                                <?php if (isset($value["xml"])) echo '<a class="btn btn-primary mr-1 mt-1 ml-4" href="index.php?pagina=page-ver-archivo&xml=' . $value["xml"] . '" target="_blank">XML</a>' ?>
                                <?php if (isset($value["comprobante"])) echo '<a class="btn btn-primary mt-1 mr-1" href="index.php?pagina=page-ver-archivo&file=' . $value["comprobante"] . '" target="_blank">Pago</a>' ?>
                            </td>
                            <td style="vertical-align: middle;"><span class="estatus  
                            <?php if ($value["estatus"] == "APROBADO")
                                echo "aprobado";
                            elseif ($value["estatus"] == "RECHAZADO")
                                echo "rechazado";
                            else
                                echo "pendiente"; ?> 
                                ">
                                    <?php echo $value["estatus"] ?>
                                </span>
                            </td>
                            <td style="vertical-align: middle;"><?php echo $value["motivo"] ?></td>
                            <td width="200px" style="vertical-align: middle;">
                                <a class="btn btn-primary btn-sm mr-1" style="justify-content: center;" href="index.php?pagina=page-po-details&id=<?php echo $value["idPo"] ?>"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a>
                                <?php
                                if ($value["estatus"] == "APROBADO")
                                    echo '
                                <a class="btn btn-primary btn-sm mr-1" href="index.php?pagina=page-ver-pdf-PO&idPO=' . $value["idPo"] . '" target="_blank">
                                    <i class="fa fa-file-pdf fa-lg" aria-hidden="true"></i>
                                </a>'
                                ?>
                                <button type="button" class="btn btn-danger btn-sm mr-1" data-toggle="modal" data-target="#modalEliminar<?php echo $value["idPo"] ?>">
                                    <i class="fa fa-trash fa-lg"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modalEliminar<?php echo $value["idPo"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-center noBordes">
                                        <h5 class="modal-title w-100" id="exampleModalLongTitle">¿Desea eliminar esta orden de compra?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer justify-content-center noBordes">
                                        <button type="button" class="btn btn-danger w-25 mr-3" data-dismiss="modal">Volver</button>
                                        <a class="btn btn-success w-25" href="index.php?pagina=delete&idPO=<?php echo $value["idPo"] ?>&estatus=<?php echo $value["estatus"] ?>">Sí
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</main>