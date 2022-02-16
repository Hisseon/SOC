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
    <div class="app-title" style="padding-top: 35px; padding-bottom: 20px">
        <div>
            <h1><i class="fa fa-edit"></i>Nueva PO</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php?pagina=page-inicio<?php echo $link ?>"><i class="fa fa-home fa-lg"></i></a></li>
            <li class="breadcrumb-item"><a href="index.php?pagina=page-user">Nueva PO</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Información de proveedor</h3>
                <div class="tile-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group row" style="align-items: center;">
                                    <label class="control-label col-md-auto" for="proveedor">Proveedor</label>
                                    <div class="col">
                                        <select class="form-control" style="height: 35px;" name="proveedor" id="proveedor">
                                            <option hidden selected value="null">Selecciona una opción</option>
                                            <?php foreach ($inst->obtnProveedores() as $key => $value) : ?>
                                                <option value="<?php echo $value["idSupplier"] ?>">
                                                    <?php echo $value["nombreComercial"] ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="align-items: center;">
                                    <label for="cotizacion" class="form-label col-md-auto">Cotización</label>
                                    <div class="col">
                                        <input class="form-control p-1" type="file" accept="application/pdf" name="cotizacion" id="cotizacion">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-group row" style="align-items: center;">
                                    <label class="control-label col-md-auto" for="divisa">Divisa</label>
                                    <div class="col">
                                        <select class="form-control" style="height: 35px;" name="divisa" id="divisa">
                                            <option hidden selected value="null">Selecciona una opción</option>
                                            <option value="MXN">MXN</option>
                                            <option value="EUR">EUR</option>
                                            <option value="USD">USD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="align-items: center;">
                                    <label for="checkbox" class="control-label col-auto">IVA</label>
                                    <div class="toggle-flip col ml-3">
                                        <label>
                                            <input class="form-control" type="checkbox" name="checkbox" id="checkbox" onclick="suma(this)"><span class="flip-indecator" data-toggle-on="SI" data-toggle-off="NO"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <h3>Productos</h3>
                            </div>
                            <div class="col text-right">
                                <button id="adicional" name="adicional" type="button" class="btn btn-success"> Agregar otro producto </button>
                            </div>
                        </div>

                        <table class="table" id="tabla">
                            <tr>
                                <th>ITEM NUMBER</th>
                                <th>DESCRIPTION 1</th>
                                <th>DESCRIPTION 2</th>
                                <th>DELIVERY DATE</th>
                                <th>QUANTITY ORDERED</th>
                                <th>UOM</th>
                                <th>UNIT COST</th>
                                <th>EXTENDED PRICE</th>
                                <th>ACTIONS</th>
                            </tr>
                            <tr class="fila-fija">
                                <td>
                                    <input class="form-control" name="itemNumber[]" id="itemNumber" />
                                </td>
                                <td>
                                    <textarea class="form-control" name="description1[]" id="description1"></textarea>
                                </td>
                                <td>
                                    <textarea class="form-control" name="description2[]" id="description2"></textarea>
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="deliveryDate[]" id="deliveryDate">
                                </td>
                                <td>
                                    <input type="number" min="0" class="form-control quantity" name="quantity[]" id="quantity" onchange="suma(this)" onkeyup="suma(this)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="UOM[]" id="UOM">
                                </td>
                                <td>
                                    <input type="number" min="0" step="any" class="form-control unitCost" name="unitCost[]" value="0" id="unitCost" onchange="suma(this)" onkeyup="suma(this)">
                                </td>
                                <td>
                                    <input class="form-control extPrice" type="number" min="0" step="any" name="extPrice[]" id="extPrice" value="0" onchange="suma(this)" onkeyup="suma(this)">
                                </td>
                                <td class="eliminar">
                                    <input type="button" class="btn btn-outline-danger" value="Eliminar" />
                                </td>

                            </tr>
                        </table>
                        <input type="text" class="form-control" name="totalPO" id="totalPO" hidden>
                        <input type="text" class="form-control" name="IVA" id="IVA" hidden>

                </div>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <h3>Comentarios adicionales</h3>
                        <textarea class="form-control" name="comments" id="comments" rows="3"></textarea>
                    </div>
                    <div class="col-auto">
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <h6>Discount(%)</h6>
                                <input type="number" class="form-control col-md-auto" name="descuento" min="0" max="100" id="descuento" value="0" onchange="suma(this)" onkeyup="suma(this)">
                            </div>
                            <div class="col-auto text-right">
                                <h5>Subtotal amount: <br>
                                    Discount amount: <br>
                                    VAT amount: <br>
                                    Total amount:
                                </h5>
                            </div>
                            <div class="col-auto text-right">
                                <h5><span id="subtotal"></span><br>
                                    <span id="discount"></span><br>
                                    <span id="vat"></span><br>
                                    <span id="total"></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tile-footer">
                    <div class="row justify-content-center">
                        <div class="col-md-auto">
                            <script>
                                document.write('<a class="btn btn-secondary mr-3" href="' + document.referrer +
                                    '"><i class="fa fa-fw fa-lg fa-times-circle"></i>Atrás</a>');
                            </script>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i>Enviar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center noBordes">
                                <h5 class="modal-title w-100" id="exampleModalLongTitle">¿La información es correcta?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer justify-content-center noBordes">
                                <button type="button" class="btn btn-danger w-25 mr-3" data-dismiss="modal">Volver</button>
                                <button type="submit" class="btn btn-success w-25">Sí</button>
                            </div>

                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</main>

<script>
    window.onload = suma(this);
    
    var uploadField = document.getElementById("cotizacion");
    var Extension = /(.pdf)$/i;
    uploadField.onchange = function() {
        if (this.files[0].size > 2097152) {
            alert("El archivo debe ser menor a 2MB");
            this.value = "";
        };
        if (!Extension.exec(uploadField.value)) {
            alert('Selecciona un archivo PDF, por favor');
            this.value = "";
        }
    };

    function suma(obj) {
        var descuento, quantity, unitCost;
        var num, str;
        var subtotal = 0;
        document.getElementById("IVA").value = 'NO';
        //Obtenemos el numero de renglones que tiene la tabla. *Restamos 1 en el ciclo For porque el encabezado cuenta.
        var rows = document.getElementById("tabla").rows.length;
        //Obtenemos los input que se encuentran en la clase unitCost y quantity, iteramos y extraemos el valor de cada uno para la operacion.
        for (let index = 0; index < rows - 1; index++) {
            quantity = parseFloat(document.getElementsByClassName("quantity")[index].value);
            unitCost = parseFloat(document.getElementsByClassName("unitCost")[index].value);
            if (quantity && unitCost) {
                num = quantity * unitCost;
                document.getElementsByClassName("extPrice")[index].value = num.toFixed(4);
            } else {
                num = 0;
            }
            subtotal += num;
        }
        var VAT = 0;
        if (document.getElementById("checkbox").checked) {
            VAT = subtotal * 0.16;
            document.getElementById("IVA").value = 'SI';
        }
        if (parseFloat(document.getElementById("descuento").value)) {
            descuento = parseFloat(document.getElementById("descuento").value) / 100;
        } else {
            descuento = 0;
        }
        var total = VAT + subtotal - ((VAT + subtotal) * descuento);
        document.getElementById("discount").innerHTML = ((VAT + subtotal) * descuento).toFixed(4);
        document.getElementById("subtotal").innerHTML = subtotal.toFixed(4);
        document.getElementById("vat").innerHTML = VAT.toFixed(4);
        document.getElementById("total").innerHTML = total.toFixed(4);
        document.getElementById("totalPO").value = total;
    }

    $(function() {
        // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $("#adicional").on('click', function() {
            $("#tabla tbody tr:eq(1)").clone().removeClass('fila-fija').appendTo("#tabla");
            suma(this);
        });

        // Evento que selecciona la fila y la elimina 
        $(document).on("click", ".eliminar", function() {
            var parent = $(this).parents().get(0);
            $(parent).remove();
            suma(this);
        });
    });
</script>

<?php
if (!empty($_POST)) {
    $registro =  new controladorFormularios;
    $registro->ctrRegistroPO();
}
