<?php
class ControladorFormularios
{

	/*=============================================
				INICIO DE SESION
	=============================================*/
	public function ctrIngreso()
	{


		if (isset($_POST["ingresoUsuario"])) {


			$tabla = "usuarios";
			$item = "userName";
			$valor = $_POST["ingresoUsuario"];
			$respuesta = ModeloFormularios::mdlSeleccionarRegistros($tabla, $item, $valor);
			if ($respuesta["userName"] == $_POST["ingresoUsuario"] && $respuesta["passw"] == $_POST["ingresoPassword"]) {

				$_SESSION["validarIngreso"] = "ok";
				$_SESSION['usuario'] = $respuesta["idUsuario"];
				$_SESSION['rol'] = $respuesta["rol"];
				$_SESSION['puesto'] = $respuesta["puesto"];
				$_SESSION['name'] = $respuesta["nombre"];
				$_SESSION['lastName'] = $respuesta["apellido"];


				if ($respuesta["rol"] == "Admin") {
					echo '<script>

				if(window.history.replaceState){
					window.history.replaceState(null, null, window.location.href);
				}

				window.location = "index.php?pagina=page-inicio";

				</script>';
				}
				if ($respuesta["rol"] == "Comprador") {
					echo '<script>

				if(window.history.replaceState){
					window.history.replaceState(null, null, window.location.href);
				}

				window.location = "index.php?pagina=page-inicio-compra";

				</script>';
				}
			} else {
				echo '<script>

				if(window.history.replaceState){
					window.history.replaceState(null, null, window.location.href);
				}

				</script>';

				echo '<div class="alert alert-danger">Error al ingresar al sistema, el usuario y/o contraseña no coinciden.</div>';
			}
		}
	}

	public function ctrRegistroUsuario()
	{
		if (isset($_POST["Name"])) {
			$data = $_POST;
			$respuesta = ModeloFormularios::mdlRegistrarUsuario($data);
			echo '<script>
				if(window.history.replaceState){
					window.history.replaceState(null, null, window.location.href);
				}
				window.location = "index.php?pagina=page-user";
				</script>';
		}
	}


	/*Las siguientes dos funciones sirven para guardar los datos en la tabla proveedores, contiene la funcionalidad para el dropzone que es administrado por la carpeta AJAX y posterioremente se hace la insercion en con la informacion de proveedor y su ruta para los archivos*/
	static public function crtSubirImagenes($datos, $ruta)
	{
		if (isset($datos["tmp_name"]) && !empty($datos["tmp_name"])) {

			$directorio = "../vistas/img/" . $ruta;

			if (!file_exists($directorio)) {
				mkdir($directorio, 0700);
			}

			$tmpFile = $_FILES['file']['tmp_name'];
			$filetype = $_FILES["file"]["type"];
			$filesize = $_FILES["file"]["size"];
			// upload file to directory
			$rutaMultimedia = $directorio . '/' . $_FILES['file']['name'];
			move_uploaded_file($tmpFile, $rutaMultimedia);


			return $rutaMultimedia;
		}
	}

	static public function crtRegistroProveedorNo()
	{
		if (isset($_POST["guardarRegistroProveedor"])) {
			$tabla = "proveedor";
			$datos = array(
				"nombreFiscal" => $_POST["nombreFiscal"],
				"nombreComercial" => $_POST["nombreComercial"],
				"negocio" => $_POST["negocio"],
				"numeroCliente" => $_POST["numeroCliente"],
				"rfc" => $_POST["rfc"],
				"correo" => $_POST["correo"],
				"direccion" => $_POST["direccion"],
				"ciudad" => $_POST["ciudad"],
				"estado" => $_POST["estado"],
				"codigoPostal" => $_POST["codigoPostal"],
				"numeroTel" => $_POST["numeroTel"],
				"tipoCompania" => $_POST["tipoCompania"],
				"moneda" => $_POST["moneda"],
				"terminoPago" => $_POST["terminoPago"],
				"tipoTrans" => $_POST["tipoTransferencia"]
				//"provFijo" => $_POST["provFijo"],
				//"files" => $_POST["files"]
			);

			$respuesta = ModeloFormularios::mdlRegistrarProveedorNo($tabla, $datos);
			return $respuesta;
		}
	}

	public static function alerta($message)
	{
		echo '<script> alert(' . $message . ') </script>';
	}

	public function obtnProveedores()
	{
		$proveedores = ModeloFormularios::mdlObtenerProveedores();
		return $proveedores;
	}

	public function dltProveedor()
	{
		$respuesta = ModeloFormularios::mdlEliminarProveedor($_GET["id"]);
		echo '<script>
        if(window.history.replaceState){
          window.history.replaceState(null, null, window.location.href);
        }
        window.location = "index.php?pagina=page-listado-proveedores";
        </script>';
	}
	public function dltPO()
	{
		$respuesta = ModeloFormularios::mdlEliminarPO($_GET["idPO"]);
		echo '<script>
        if(window.history.replaceState){
          window.history.replaceState(null, null, window.location.href);
        }
        window.location = "index.php?pagina=page-historial-compras";
        </script>';
	}
	public function dltUsuario()
	{
		$respuesta = ModeloFormularios::mdlEliminarUsuario($_GET["idUsuario"]);
		echo '<script>
        if(window.history.replaceState){
          window.history.replaceState(null, null, window.location.href);
        }
        window.location = "index.php?pagina=page-listado-usuarios";
        </script>';
	}

	public function ctrRegistroPO()
	{
		if (isset($_POST["proveedor"])) {
			$data = $_POST;
			$id = ModeloFormularios::mdlRegistrarPO($data, $_SESSION['usuario']);

			$directorio = 'assets/archivos/';
			$fecha = date("dmY");
			$nombre_archivo = basename('PO-ID' . $id['idPo'] . '-cotizacion-' . $fecha . '.pdf');
			$cotizacion = ModeloFormularios::mdlUpdateCotizacion($id['idPo'], $nombre_archivo);

			$subir_archivo = $directorio . $nombre_archivo;
			if (move_uploaded_file($_FILES['cotizacion']['tmp_name'], $subir_archivo)) {
				echo '<script> alert("Orden de compra creada correctamente.") </script>';
			} else {
				echo '<script> alert("Error al cargar el archivo.") </script>';
				$respuesta = ModeloFormularios::mdlEliminarPO($id['idPo'], null);
				return;
			}

			echo '<script>
        		if(window.history.replaceState){
        		  window.history.replaceState(null, null, window.location.href);
        		}
        		window.location = "index.php?pagina=page-PO";
        		</script>';
		}
	}

	public function ctrUpdateFactura()
	{
		$data = $_POST;
		$directorio = 'assets/archivos/';
		$fechaNombre = date("dmY");
		$nombre_factura = basename('PO-ID' . $data['idPO'] . '-invoice-' . $fechaNombre . '.pdf');
		$subir_factura = $directorio . $nombre_factura;
		if (!empty($_FILES["xml"]["name"])) {
			$nombre_xml = basename('PO-ID' . $data['idPO'] . '-xml-' . $fechaNombre . '.xml');
			$subir_xml = $directorio . $nombre_xml;
		} else {
			$subir_xml = null;
		}

		$cond1 = move_uploaded_file($_FILES['invoice']['tmp_name'], $subir_factura);
		$cond2 = move_uploaded_file($_FILES['xml']['tmp_name'], $subir_xml);
		$cond3 = !empty($_POST["fecha"]);

		if ($cond1 && ($cond2 || $cond3)) {
			echo '<script> alert("Información almacenada correctamente.") </script>';
			if ($cond3) {
				$fecha = $_POST["fecha"];
			} else {
				//Manipulacion de XML
				$xml = simplexml_load_file($subir_xml);
				$fecha = $xml->attributes()->Fecha;
				$fecha = strtotime($fecha);
				$fecha = date('Y-m-d', $fecha);
			}
			$respuesta = ModeloFormularios::mdlUpdateFactura($data['idPO'], $nombre_factura, $nombre_xml, $fecha);
		} else {
			echo '<script> alert("Error al subir la información.") </script>';
		}

		echo '<script>
        		if(window.history.replaceState){
        		  window.history.replaceState(null, null, window.location.href);
        		}
        		window.location = "index.php?pagina=page-inicio-compra";
        		</script>';
	}

	public function ctrUpdatePago()
	{
		$data = $_POST;
		$directorio = 'assets/archivos/';
		$fecha = date("dmY");
		$nombre_pago = basename('PO-ID' . $data['idPO'] . '-pago-' . $fecha . '.pdf');

		$subir_pago = $directorio . $nombre_pago;
		if (move_uploaded_file($_FILES['pago']['tmp_name'], $subir_pago)) {
			echo '<script> alert("Archivo subido correctamente.") </script>';
			$respuesta = ModeloFormularios::mdlUpdatePago($data['idPO'], $nombre_pago);
		} else {
			echo '<script> alert("Error al cargar el archivo.") </script>';
		}

		echo '<script>
        		if(window.history.replaceState){
        		  window.history.replaceState(null, null, window.location.href);
        		}
        		window.location = "index.php?pagina=page-inicio";
        		</script>';
	}

	public function obtnHistorial()
	{
		$historial = ModeloFormularios::mdlObtenerHistorial($_SESSION['usuario'], $_SESSION["rol"]);
		return $historial;
	}

	public function ObtenerProveedores()
	{
		$proveedores = ModeloFormularios::mdlObtenerProveedores();
		return $proveedores;
	}

	public function obtnHistorialPendientesAprobacion()
	{
		$historial = ModeloFormularios::mdlObtenerHistorialPendientesAprobacion($_SESSION['usuario'], $_SESSION["rol"]);
		return $historial;
	}

	public function obtnHistorialPendientesFactura()
	{
		$historial = ModeloFormularios::mdlObtenerHistorialPendientesFactura($_SESSION['usuario'], $_SESSION["rol"]);
		return $historial;
	}

	public function obtnHistorialPendientesPago()
	{
		$historial = ModeloFormularios::mdlObtenerHistorialPendientesPago($_SESSION['usuario'], $_SESSION["rol"]);
		return $historial;
	}

	public function obtnDetallesPO()
	{
		$data = ModeloFormularios::mdlObtenerDetallesPO($_GET['id']);
		return $data;
	}

	public function ctrActualizarEstatusPO()
	{
		$data = $_POST;
		$respuesta = ModeloFormularios::mdlEstatusPO($data, $_GET['id']);
		echo '<script>
        		if(window.history.replaceState){
        		  window.history.replaceState(null, null, window.location.href);
        		}
        		window.location = history.go(-2);
        		</script>';
	}
	public function obtenerData()
	{
		$data = ModeloFormularios::mdlObtenerData($_GET['idPO']);
		return $data;
	}
	public function obtenerProductos()
	{
		$data = ModeloFormularios::mdlObtenerProductos($_GET['idPO']);
		return $data;
	}

	public function exportarPO($id){
		$data = ModeloFormularios::mdlExportarPO($id);
		return $data;
	}

	public function exportarProductos($id){
		$data = ModeloFormularios::mdlObtenerProductos($id);
		return $data;
	}

	public function ctrActualizarFechaPago(){
		$data = $_POST;
		$respuesta = ModeloFormularios::mdlActualizarFechaPago($data);
		echo '<script>
        		if(window.history.replaceState){
        		  window.history.replaceState(null, null, window.location.href);
        		}
        		window.location = "index.php?pagina=page-inicio";
        		</script>';
	}
}
