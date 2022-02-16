<?php
ob_clean();
require_once "../../models/formularios.modelo.php";
require_once "../../controllers/formularios.controlador.php";
require_once "../../assets/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$id = $_POST["idExport"];
$inst = new ControladorFormularios;

$spread = new Spreadsheet();
$spread
    ->getProperties()
    ->setTitle('Informacion exportada')
    ->setSubject('Ordenes de compra');
$sheet = $spread->getActiveSheet();
$sheet->setTitle("Ordenes");
foreach (range('A', 'K') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$actualRow = 1;

foreach ($id as $id) {
    $encabezadoPO = ["ID PO", "No.Factura", "Comprador", "Proveedor", "Total"];
    $sheet->fromArray($encabezadoPO, null, "A$actualRow");
    $actualRow++;
    $data = $inst->ExportarPO($id);
    $sheet->setCellValueByColumnAndRow(1, $actualRow, $data["idPo"]);
    $sheet->setCellValueByColumnAndRow(2, $actualRow, $data["idInvoice"]);
    $sheet->setCellValueByColumnAndRow(3, $actualRow, $data["nombre"] . " " . $data["apellido"]);
    $sheet->setCellValueByColumnAndRow(4, $actualRow, $data["nombreComercial"]);
    $sheet->setCellValueByColumnAndRow(5, $actualRow, "$" . $data["total"] . " " . $data["divisa"]);
    $actualRow += 2;
    $sheet->setCellValueByColumnAndRow(1, $actualRow, "Productos");
    $actualRow++;
    $encabezadoProd = ["Item Number", "Description 1", "Description 2", "Delivery Date", "Quantity", "UOM", "Unit Cost", "Extended Price"];
    $sheet->fromArray($encabezadoProd, null, "A$actualRow");
    $actualRow++;
    foreach ($inst->exportarProductos($id) as $key => $value) {
        $sheet->setCellValueByColumnAndRow(1, $actualRow, $value["itemNumber"]);
        $sheet->setCellValueByColumnAndRow(2, $actualRow, $value["description1"]);
        $sheet->setCellValueByColumnAndRow(3, $actualRow, $value["description2"]);
        $sheet->setCellValueByColumnAndRow(4, $actualRow, $value["fecha"]);
        $sheet->setCellValueByColumnAndRow(5, $actualRow, $value["quantity"]);
        $sheet->setCellValueByColumnAndRow(6, $actualRow, $value["UOM"]);
        $sheet->setCellValueByColumnAndRow(7, $actualRow, "$" . $value["unitCost"]);
        $sheet->setCellValueByColumnAndRow(8, $actualRow, "$" . $value["extendedPrice"]);
        $actualRow++;
    }
    $actualRow += 2;
}
$fecha = date("dmY");
$fileName = "ExportedData-$fecha.xlsx";
# Crear un "escritor"
$writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
$writer->save('php://output');
