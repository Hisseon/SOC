<?php
include 'barAdmin.php';
?>

<main class="app-content">
    <div class="app-title" style="padding-top: 35px; padding-bottom:20px">
        <div>
            <h1><i class="fa fa-edit"></i> Alta de Proveedor</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="index.php?pagina=page-proveedor">Alta Proveedor</a></li>
        </ul>
    </div>
    <div class="row">
        
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">INFORMACIÓN REQUERIDA PARA ALTA DE NUEVOS PROVEEDORES</h3>
                <div class="tile-body">
                    <form class="form-horizontal" method="POST">
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nombre Fiscal</label>
                            <input class="form-control col-md-8" id="nombreFiscal" name="nombreFiscal" type="text"
                                placeholder="Ingresa Nombre Fiscal">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Nombre Comercial</label>
                            <input class="form-control col-md-8" id="nombreComercial" name="nombreComercial" type="text"
                                placeholder="Ingresa Nombre Comercial">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Negocio</label>
                            <input class="form-control col-md-8" id="negocio" name="negocio" type="text"
                                placeholder="Ingresa Negocio del Proveedor">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Número del cliente para PASSMEX</label>
                            <input class="form-control col-md-8" id="numeroCliente" name="numeroCliente" type="text"
                                placeholder="Ingresa No de cliente">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">RFC</label>
                            <input class="form-control col-md-8" id="rfc" name="rfc" type="text"
                                placeholder="Ingresa RFC">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Correo</label>
                            <input class="form-control col-md-8" id="correo" name="correo" type="email"
                                placeholder="Ingresa Correo">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Dirección</label>
                            <textarea class="form-control col-md-8" id="direccion" name="direccion" rows="4"
                                placeholder="Ingresa la dirección completa"></textarea>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Ciudad</label>
                            <input class="form-control col-md-8" id="ciudad" name="ciudad" type="text"
                                placeholder="Ingresa Ciudad">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Estado</label>
                            <input class="form-control col-md-8" id="estado" name="estado" type="text"
                                placeholder="Ingresa Estado">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Código Postal</label>
                            <input class="form-control col-md-8" id="codigoPostal" name="codigoPostal" type="text"
                                placeholder="Ingresa CP">
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Número telefónico</label>
                            <input class="form-control col-md-8" id="numeroTel" name="numeroTel" type="text"
                                placeholder="Ingresa número telefónico">
                        </div>


                        <div class="form-group row">
                            <label class="control-label col-md-3">Tipo de Compañía</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="tipoCompania" id="Sociedad"
                                            value="sociedad">Sociedad
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="tipoCompania"
                                            id="personapart" value="personapart">Persona Particular
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="tipoCompania" id="otro"
                                            value="otro">Otro
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="control-label col-md-3">Moneda</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="moneda" id="mxn"
                                            value="mxn">MXN
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="moneda" id="usd"
                                            value="usd">USD
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="moneda" id="eur"
                                            value="eur">EUR
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="control-label col-md-3">Término de pago acordado</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="terminoPago" id="1"
                                            value="1">Contado
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="terminoPago" id="30"
                                            value="30">30 días
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="terminoPago" id="14"
                                            value="14">14 días con 3% desc
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label class="control-label col-md-3">Tipo Transferencia</label>
                            <div class="col-md-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="tipoTransferencia" id="nac"
                                            value="nac">Nacional
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="tipoTransferencia" id="inter"
                                            value="inter">Internacional
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="d-flex justify-content-center h-100 d-inline-block p-2">
                            <input type="submit" name="guardarRegistroProveedor" class="btn btn-success" />
                        </div>

                        <div class="col-md-6">
                            <div class="tile">
                                <div class="tile-body">
                                    <form class="form-horizontal">
                                        <p><b>Proveedor Fijo</b></p>
                                        <div class="toggle-flip">
                                            <label>
                                                <input type="checkbox" name="checkbox"><span class="flip-indecator"
                                                    data-toggle-on="SI" data-toggle-off="NO"></span>
                                            </label>
                                        </div>
                                    </form>
                                    <br>
                                </div>

                                <div class="tile">
                                    <div class="tile-title-w-btn">
                                        <h3 class="title">Documentos</h3>
                                    </div>
                                    <div class="tile-body">
                                        <form class="text-center dropzone" name="archivosProveedor" method="POST"
                                            enctype="multipart/form-data" action="/file-upload">
                                            <div class="dz-message">Deposite aqui los documentos del proveedor<br><small
                                                    class="text-info">(RFC, Acta constitutiva, Opinion Positiva, Estado
                                                    de cuenta, Comprobante de Domicilio y Documento de Alta de
                                                    Proveedor.)</small></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>

            </div>




        </div>





</main>



<!-- Essential javascripts for application to work-->

<script type="text/javascript" src="assets/js/plugins/dropzone.js"></script>

<?php
    /*FORMA QUE SE INSTANCIA LA CLASE DE UN METODO NO ESTATICO*/
        //$registro = new controladorFormularios();
        //$registro -> crtRegistroProveedorNo();

    /*FORMA QUE SE INSTANCIA LA CLASE DE UN METODO ESTATICO*/
       $registro = controladorFormularios::crtRegistroProveedorNo();
        //echo $registro;

        if ($registro == "ok") {

            echo '<script>

                if(window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                }

            </script>';

            echo '<div class="alert alert-success">El proveedor ha sido registrada</div>';
        }

    ?>

<script>
function countChars(obj) {
    var maxLength = document.getElementById("comentario").maxLength;
    var strLength = obj.value.length;
    var charRemain = (maxLength - strLength);

    if (charRemain <= 0) {
        document.getElementById("charNum").innerHTML = '<span style="color: red;">Excediste el límite de ' + maxLength +
            ' caracteres</span>';
    } else {
        document.getElementById("charNum").innerHTML = charRemain + ' caracteres restantes';
    }
}

function submitClick() {
    if (formValidation() == true) {
        return true;
    } else {
        return false;
    }
}

function formValidation() {
    var alertPlaceholder = document.getElementById('errorMoneda')
    if (document.Form.moneda.value == '') {
        alert('Seleccione una moneda, por favor.', 'danger', alertPlaceholder)
        return false;
    }
    return true;
}

function alert(message, type, placeHolder) {
    var wrapper = document.createElement('div')
    wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'

    placeHolder.append(wrapper)
}
</script>

<?php
//if (!empty($_POST)) {
//  $registro =  new controladorFormularios;
//  $registro->ctrRegistroProveedor();
//}
?>