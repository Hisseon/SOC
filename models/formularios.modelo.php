<?php
require_once "conexion.php";

class ModeloFormularios
{

	/*=============================================
	Seleccionar Registro
	=============================================*/

	static public function mdlSeleccionarRegistros($tabla, $item, $valor)
	{

		if ($item == null && $valor == null) {
			$stmt = Conexion::conectar()->prepare("SELECT *  FROM $tabla");
			$stmt->execute();

			return $stmt->fetchALL();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  WHERE $item = :$item");
			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetch();
		}

		$stmt = null;
	}

	/*=============================================
	Registrar Usuario
	=============================================*/

	static public function mdlRegistrarUsuario($data)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO usuarios (nombre, apellido, userName, passw, rol, puesto) VALUES (?,?,?,?,?,?)");
		$stmt->execute(array($data["Name"], $data["lastName"], $data["userName"], $data["password"], $data["role"], $data["puesto"]));
		return $stmt->fetch();
		$stmt = null;
	}

	static public function mdlRegistrarProveedorNo($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombreFiscal, nombreComercial, negocio, numeroCliente, rfc, correo, direccion, ciudad, estado, codigoPostal, numeroTel, tipoCompañia, terminoPago, tipotrans) VALUES (:nombreFiscal, :nombreComercial, :negocio, :numeroCliente, :rfc, :correo, :direccion, :ciudad, :estado, :codigoPostal, :numeroTel, :tipoCompania, :terminoPago, :tipoTrans)");

		#bindParam() Vincula una variable de PHP a un parámetro de sustitución con nombre o de signo de interrogación correspondiente de la sentencia SQL que fue usada para preparar la sentencia.

		$stmt->bindParam(":nombreFiscal", $datos["nombreFiscal"], PDO::PARAM_STR);
		$stmt->bindParam(":nombreComercial", $datos["nombreComercial"], PDO::PARAM_STR);
		$stmt->bindParam(":negocio", $datos["negocio"], PDO::PARAM_STR);
		$stmt->bindParam(":numeroCliente", $datos["numeroCliente"], PDO::PARAM_STR);
		$stmt->bindParam(":rfc", $datos["rfc"], PDO::PARAM_STR);
		$stmt->bindParam(":correo", $datos["correo"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":codigoPostal", $datos["codigoPostal"], PDO::PARAM_STR);
		$stmt->bindParam(":numeroTel", $datos["numeroTel"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoCompania", $datos["tipoCompania"], PDO::PARAM_STR);
		$stmt->bindParam(":terminoPago", $datos["terminoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoTrans", $datos["tipoTrans"], PDO::PARAM_STR);
		//$stmt->bindParam(":provfijo", $datos["provfijo"], PDO::PARAM_STR);
		//$stmt->bindParam(":files", $datos["files"], PDO::PARAM_STR);


		if ($stmt->execute()) {

			return "ok";
		} else {

			//print_r(Conexion::conectar()->errorInfo());

		}

		$stmt = null;
	}


	/*=============================================
	Seleccionar Proveedores
	=============================================*/

	static public function mdlObtenerProveedores()
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM proveedor");
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlEliminarProveedor($id)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM proveedor WHERE idSupplier = ?");
		$stmt->execute(array($id));
		return $stmt->fetch();
		$stmt = null;
	}

	static public function mdlEliminarUsuario($id)
	{
		$stmt = Conexion::conectar()->prepare("DELETE FROM usuario WHERE idUsuario = ?");
		$stmt->execute(array($id));
		return $stmt->fetch();
		$stmt = null;
	}

	static public function mdlEliminarPO($id)
	{
		//Obtenemos el nombre del archivo que se eliminara
		$stmt = Conexion::conectar()->prepare("SELECT c.cotización, f.factura, f.xml, p.comprobante FROM compras AS c 
												LEFT JOIN facturas AS f ON c.idPO = f.idPO
												LEFT JOIN pago AS p ON c.idPO = p.idPO
												WHERE c.idPo = ?");
		$stmt->execute(array($id));
		$data = $stmt->fetch();
		$cotizacion = $data["cotización"];
		$factura = $data["factura"];
		$xml = $data["xml"];
		$pago = $data["comprobante"];

		//Realizamos la funcion para eliminar
		$dir = 'assets/archivos/';
		if (file_exists($dir . $cotizacion) && $cotizacion != null)
			unlink($dir . $cotizacion);
		if (file_exists($dir . $factura) && $factura != null)
			unlink($dir . $factura);
		if (file_exists($dir . $xml) && $xml != null)
			unlink($dir . $xml);
		if (file_exists($dir . $pago) && $pago != null)
			unlink($dir . $pago);
		//Eliminamos la PO de la base de datos
		$stmt = Conexion::conectar()->prepare("DELETE FROM compras WHERE idPo = ?");
		$stmt->execute(array($id));
		return $stmt->fetch();
		$stmt = null;
	}



	static public function mdlIngresaProducto($datos)
	{
		$stm = Conexion::conectar()->prepare("INSERT INTO galeria(titulo, imagenes) VALUES (:titulo, :imagenes)");
		$stm->bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
		$stm->bindParam(":imagenes", $datos["multimedia"], PDO::PARAM_STR);
		if ($stm->execute()) {
			return "ok";
		} else {
			return "error";
		}
		$stm = null;
	}

	static public function mdltraerimagenes($id)
	{
		$stm = Conexion::conectar()->prepare("SELECT * FROM galeria WHERE id = :id");
		$stm->bindParam(":id", $id, PDO::PARAM_INT);
		if ($stm->execute()) {
			return $stm->fetch();
		} else {
			return "error";
		}
		$stm = null;
	}

	/*=============================================
	Obtener hisorial de compras
	=============================================*/
	static public function mdlObtenerHistorial($idUsuario, $rol)
	{
		if ($rol == "Comprador") {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, 
												 c.cotización, c.estatus, c.motivo, c.idSupplier, c.divisa, f.xml, f.factura,
												 f.fechaFacturación AS fechaPago, pa.comprobante FROM compras AS c 
												 INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 LEFT JOIN pago AS pa ON c.idPo = pa.idPo
												 LEFT JOIN facturas AS f ON c.idPo = f.idPo
												 WHERE c.idUsuario = ? ORDER BY c.idPo");
			$stmt->execute(array($idUsuario));
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo,
												c.cotización, c.estatus, c.motivo, c.idSupplier, c.divisa, f.xml, f.factura,
												f.fechaFacturación AS fechaPago, pa.comprobante FROM compras AS c 
												INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												LEFT JOIN pago AS pa ON c.idPo = pa.idPo
												LEFT JOIN facturas AS f ON c.idPo = f.idPo ORDER BY c.idPo");
			$stmt->execute();
		}
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlObtenerHistorialPendientesAprobacion($idUsuario, $rol)
	{
		if ($rol == "Comprador") {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo, c.idSupplier, pt.total, c.divisa
												 FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 INNER JOIN productostotal AS pt on c.idPo = pt.idPo
												 WHERE c.idUsuario = ? AND c.estatus = 'PENDIENTE'");
			$stmt->execute(array($idUsuario));
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo, c.idSupplier, pt.total, c.divisa
												 FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 INNER JOIN productostotal AS pt on c.idPo = pt.idPo
												 WHERE c.estatus = 'PENDIENTE'");
			$stmt->execute();
		}
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlObtenerHistorialPendientesFactura($idUsuario, $rol)
	{
		if ($rol == "Comprador") {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo, c.idSupplier, pt.total, c.divisa
												 FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 INNER JOIN productostotal AS pt ON c.idPo = pt.idPo
												 INNER JOIN facturas AS f ON f.idPo = c.idPo
												 WHERE c.idUsuario = ? AND f.XML IS NULL AND f.factura IS NULL");
			$stmt->execute(array($idUsuario));
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo, c.idSupplier, pt.total, c.divisa
												 FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 INNER JOIN productostotal AS pt ON c.idPo = pt.idPo
												 INNER JOIN facturas AS f ON f.idPo = c.idPo
												 WHERE f.XML IS NULL AND f.factura IS NULL");
			$stmt->execute();
		}
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlObtenerHistorialPendientesPago($idUsuario, $rol)
	{
		if ($rol == "Comprador") {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo,
												 c.idSupplier, pt.total, c.divisa, f.fechaFacturación AS fechaPago, f.idInvoice
												 FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 INNER JOIN productostotal AS pt ON c.idPo = pt.idPo
												 INNER JOIN facturas AS f ON f.idPo = c.idPo
												 INNER JOIN pago AS pa ON c.idPo = pa.idPo
												 WHERE c.idUsuario = ? AND f.fechaFacturación IS NOT NULL AND f.factura IS NOT NULL AND pa.comprobante IS NULL
												 ORDER BY fechaPago ASC");
			$stmt->execute(array($idUsuario));
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo,
												 c.idSupplier, pt.total, c.divisa, f.fechaFacturación AS fechaPago, f.idInvoice
												 FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
												 INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												 INNER JOIN productostotal AS pt ON c.idPo = pt.idPo
												 INNER JOIN facturas AS f ON f.idPo = c.idPo
												 INNER JOIN pago AS pa ON c.idPo = pa.idPo
												 WHERE f.fechaFacturación IS NOT NULL AND f.factura IS NOT NULL AND pa.comprobante IS NULL
												 ORDER BY fechaPago ASC");
			$stmt->execute();
		}
		return $stmt->fetchAll();
		$stmt = null;
	}

	/*=============================================
	Registrar nueva PO
	=============================================*/
	static public function mdlRegistrarPO($data, $idUsuario)
	{
		//Se obtiene la longitud del array para iterar la query
		$arr_length = count($data["itemNumber"]);

		//Se inserta la nueva PO
		$stmt = Conexion::conectar()->prepare("INSERT INTO compras (idUsuario, idSupplier, fechaPo, divisa, IVA, estatus) VALUES (?, ?, CURDATE(), ?, ?, 'PENDIENTE')");
		$stmt->execute(array($idUsuario, $data["proveedor"], $data["divisa"], $data["IVA"]));

		//Se obtiene el id de la última PO del usuario en cuestión
		$stmt = Conexion::conectar()->prepare("SELECT MAX(idPo) AS idPo FROM compras WHERE idUsuario = ?");
		$stmt->execute(array($idUsuario));
		$id = $stmt->fetch();

		$stmt = Conexion::conectar()->prepare("INSERT INTO productostotal(idPO, total, otherComments) VALUES (?, ?, ?)");
		$stmt->execute(array($id["idPo"], $data["totalPO"], $data["comments"]));

		//Se prepara la query para insertar los productos enlazados a la PO previamente creada
		$stmt = Conexion::conectar()->prepare("INSERT INTO productos(idPO, itemNumber, description1, description2, deliveryDate, quantity,
												UOM, unitCost, extendedPrice) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		for ($i = 0; $i < $arr_length; $i++) {
			$stmt->execute(array(
				$id["idPo"], $data["itemNumber"][$i], $data["description1"][$i], $data["description2"][$i], $data["deliveryDate"][$i],
				$data["quantity"][$i], $data["UOM"][$i], $data["unitCost"][$i], $data["extPrice"][$i]
			));
		}
		return $id;
		$stmt = null;
	}

	static public function mdlUpdateCotizacion($id, $nombre_archivo)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE compras SET cotización = ? WHERE idPO = ?");
		$stmt->execute(array($nombre_archivo, $id));
		return $stmt->fetch();
		$stmt = null;
	}

	/*=============================================
	Obtener detalles de PO
	=============================================*/

	static public function mdlObtenerDetallesPO($id)
	{
		$stmt = Conexion::conectar()->prepare("SELECT prov.nombreComercial, p.itemNumber, p.description1, p.description2, p.deliveryDate,
											 p.quantity, p.UOM, p.unitCost, p.extendedPrice, pt.total, pt.otherComments, c.estatus, c.divisa, c.IVA, c.cotización FROM compras AS c
											 INNER JOIN productos AS p ON c.idPo = p.idPO
											 INNER JOIN productostotal AS pt ON c.idPo = pt.idPO
											 INNER JOIN proveedor AS prov ON c.idSupplier = prov.idSupplier
											 WHERE c.idPo = ?");
		$stmt->execute(array($id));
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlEstatusPO($data, $id)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO facturas (idPO) VALUES (?)");
		$stmt->execute(array($id));

		$stmt = Conexion::conectar()->prepare("INSERT INTO pago (idPO, idFactura) VALUES (?, (SELECT idInvoice FROM facturas WHERE idPO = ?))");
		$stmt->execute(array($id, $id));

		$stmt = Conexion::conectar()->prepare("UPDATE compras SET motivo = ?, estatus = ? WHERE idPo = ?");
		$stmt->execute(array($data["motivo"], $data["estatus"], $id));
		return $stmt->fetch();
		$stmt = null;
	}

	/*=============================================
	Obtener informacion para PDF
	=============================================*/

	static public function mdlObtenerData($idPO)
	{
		$stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(c.fechaPo, '%d-%m-%Y')AS fecha , LPAD(c.idPO, 7, '0') AS numPO FROM compras AS c
												INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
												INNER JOIN productostotal AS pt ON c.idPO = pt.idPO
												INNER JOIN usuarios AS u ON u.idUsuario = c.idUsuario
												WHERE c.idPO = ?");
		$stmt->execute(array($idPO));
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlObtenerProductos($idPO)
	{
		$stmt = Conexion::conectar()->prepare("SELECT *, DATE_FORMAT(deliveryDate, '%d-%m-%Y') AS fecha FROM productos WHERE idPO = ?");
		$stmt->execute(array($idPO));
		return $stmt->fetchAll();
		$stmt = null;
	}

	static public function mdlUpdateFactura($idPO, $nombre_factura, $nombre_xml, $fecha)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE facturas SET factura = ?, xml = ?,
											fechaFacturación = (SELECT ADDDATE(?, p.terminoPago) FROM proveedor AS p
											INNER JOIN compras AS c ON p.idSupplier = c.idSupplier
											WHERE c.idPo = ?) WHERE idPO = ?");
		$stmt->execute(array($nombre_factura, $nombre_xml, $fecha, $idPO, $idPO));
		return $stmt->fetch();
		$stmt = null;
	}
	static public function mdlUpdatePago($idPO, $nombre_pago)
	{
		$stmt = Conexion::conectar()->prepare("UPDATE pago SET comprobante = ? WHERE idPO = ?");
		$stmt->execute(array($nombre_pago, $idPO));
		return $stmt->fetch();
		$stmt = null;
	}

	static public function mdlExportarPO($id)
	{
		$stmt = Conexion::conectar()->prepare("SELECT c.idPo, u.nombre, u.apellido, p.nombreComercial, c.fechaPo, c.cotización, c.estatus, c.motivo,
											c.idSupplier, pt.total, c.divisa, f.fechaFacturación AS fechaPago, f.idInvoice
											FROM compras AS c INNER JOIN usuarios AS u ON c.idUsuario = u.idUsuario 
											INNER JOIN proveedor AS p ON c.idSupplier = p.idSupplier
											INNER JOIN productostotal AS pt ON c.idPo = pt.idPo
											INNER JOIN facturas AS f ON f.idPo = c.idPo
											WHERE c.idPo = ?");
		$stmt->execute(array($id));
		return $stmt->fetch();
		$stmt = null;
	}

	static public function mdlActualizarFechaPago($data){
		$stmt = Conexion::conectar()->prepare("UPDATE facturas SET fechaFacturación = ? WHERE idPo = ?");
		$stmt->execute(array($data["fecha"], $data["idPO"]));
		return $stmt->fetch();
		$stmt = null;
	}
}
