<?php
ob_end_clean();
$inst = new ControladorFormularios;
$data = $inst->obtenerData();
$IVA = 0;
$subtotal = $data[0]['total'];
if ($data[0]['IVA'] == "SI") {
    $subtotal = $data[0]['total'] / 1.1600;
    $IVA = $data[0]['total'] - $subtotal;
}
ob_start();
?>

<html>

<head>
    <title>PurchaseOrder_ID<?php echo $_GET['idPO'] ?></title>
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SOC/assets/css/style.css">
</head>

<body>
    <!--**************************************** Informacion de cabecera ****************************************-->
    <table>
        <tr>
            <td style="width: 28%;">
                <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/SOC/assets/images/pass.png" height="65">
            </td>
            <td style="text-align: left; width: 65%;">
                <span class="text">
                    PASS AUTOMOTIVE MEXICO S.A. DE C.V. <br>
                </span>
                <span class="subtextB">
                    LIBRAMIENTO LEÓN QUERÉTARO KM 4.6 LOTE 18 <br>
                    PARQUE INDUSTRIAL APOLO <br>
                    RFC: PAM130308SJ0 <br>
                    IRAPUATO, GUANAJUATO <br>
                    TEL:(462) 8006300
                </span>
            </td>
            <td style="vertical-align: text-top;">
                <span class="focom">FO-COM-01</span>
            </td>
        </tr>
    </table>
    <!--**************************************** Informacion del vendedor y empresa ****************************************-->
    <table style="margin-top: 10px;">
        <tr>
            <td>
                <span class="subtextB">VENDOR</span>
            </td>
            <td class="gray" style="text-align: center; width: 100px;">
                <span class="subtext"><?php echo $data[0]['idSupplier'] ?></span>
            </td>
            <td style="width: 294px;"></td>
            <td style="text-align: center">
                <span class="subtextB">SHIP TO</span>
            </td>
        </tr>
    </table>
    <!--**************************************** Informacion del comprador y la orden de compra ****************************************-->
    <table style="margin-top: 10px;">
        <tr>
            <td class="gray" style="width: 325px;">
                <span class="subtext">
                    <?php echo mb_strtoupper($data[0]['nombreComercial']) ?><br>
                    <?php echo mb_strtoupper($data[0]['direccion']) ?><br>
                    <?php echo mb_strtoupper($data[0]['rfc']) ?><br>
                    <?php echo mb_strtoupper($data[0]['ciudad'] . ' ' . $data[0]['estado']) ?>
                </span>
            </td>
            <td style="width: 125px;">
            </td>
            <td>
                <span class="subtext">
                    PASS AUTOMOTIVE MEXICO S.A. DE C.V. <br>
                    LIBRAMIENTO LEÓN QUERÉTARO KM 4.6 LOTE 18 <br>
                    PARQUE INDUSTRIAL APOLO <br>
                    TAX ID: PAM130308SJ0 <br>
                    IRAPUATO GUANAJUATO
                </span>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 210px; vertical-align: bottom;">
                <span class="subtextB">PAYMENT TERMS</span>
            </td>
            <td style="width: 40px;"></td>
            <td style="width: 220px; vertical-align: bottom;">
                <span class="subtextB">BUYER NAME</span>
            </td>
            <td style="width: 90px;"></td>
            <td rowspan="2" class="center">
                <span class="purchase">
                    PURCHASE<br>
                    ORDER NO: <br>
                    <?php echo $data[0]['numPO'] . '-000-PO' ?>
                </span>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: baseline;">
                <div class="gray" style="padding:3px">
                    <span class="subtext"><?php echo $data[0]['terminoPago'] . ' DAYS' ?></span>
                </div>
            </td>
            <td>
            </td>
            <td style="vertical-align: baseline;">
                <div class="gray" style="padding:3px">
                    <span class="subtext"><?php echo mb_strtoupper($data[0]['nombre'] . ' ' . $data[0]['apellido']) ?></span>
                </div>
            </td>
            <td>
            </td>
        </tr>
    </table>
    <table class="tableA" style="margin-top: 5px;">
        <tr>
            <td class="subtextB" style="width: 210px; vertical-align: bottom;">
                CARRIER NUMBER
            </td>
            <td style="width: 40px;"></td>
            <td style="width: 220px; vertical-align: bottom;">
                <span class="subtextB">DIRECT PHONE BUYER</span>
            </td>
            <td style="width: 65px;"></td>
            <td rowspan="2">
                <table class="tableB">
                    <tr>
                        <td>
                            <span class="subtextB">CURRENCY</span>
                        </td>
                        <td class="gray center">
                            <span class="subtext"><?php echo mb_strtoupper($data[0]['divisa']) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="subtextB">DATE DD/MM/YYYY</span>
                        </td>
                        <td class="gray center">
                            <span class="subtext"><?php echo $data[0]['fecha'] ?></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="gray center">
                <span class="subtext">N/A</span>
            </td>
            <td>
            </td>
            <td class="gray center">
                <span class="subtext">N/A</span>
            </td>
            <td>
            </td>
        </tr>
    </table>
    <!--**************************************** Informacion de los productos ****************************************-->
    <table id="detalle_productos" class="tableP" style="margin-top: 15px;">
        <thead>
            <tr class="subtextB">
                <th style="width: 10px;">LINE<br>NO.</th>
                <th style="width: 100px;">ITEM <br> NUMBER</th>
                <th style="width: 120px;">DESCRIPTION 1</th>
                <th style="width: 120px;">DESCRIPTION 2</th>
                <th>DELIVERY <br> DATE</th>
                <th style="width: 60px;">QUANTITY <br> ORDERED</th>
                <th style="width: 40px;">UOM</th>
                <th>UNIT COST</th>
                <th>EXTENDED <br> PRICE</th>
            </tr>
        </thead>
        <tbody class="subtext center">
            <?php foreach ($inst->obtenerProductos() as $key => $value) : ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $value["itemNumber"] ?></td>
                    <td><?php echo mb_strtoupper($value["description1"]) ?></td>
                    <td><?php echo mb_strtoupper($value["description2"]) ?></td>
                    <td><?php echo $value["fecha"] ?></td>
                    <td><?php echo $value["quantity"] ?></td>
                    <td><?php echo mb_strtoupper($value["UOM"]) ?></td>
                    <td><?php echo '$' . number_format($value["unitCost"], 4) ?></td>
                    <td><?php echo '$' . number_format($value["extendedPrice"], 4) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <!--**************************************** Informacion de costos ****************************************-->
    <table class="tableT" width="40%">
        <tr class="subtext">
            <td class="subtextB">SUBTOTAL AMOUNT</td>
            <td class="center gray" width="86px">
                <table class="tablaAnidada">
                    <tr>
                        <td>
                            $
                        </td>
                        <td class="right">
                            <?php echo number_format($subtotal, 4) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="subtext">
            <td class="subtextB">DISCOUNT AMOUNT</td>
            <td class="center gray">
                <table class="tablaAnidada">
                    <tr>
                        <td>
                            $
                        </td>
                        <td class="right">
                            -
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="subtext">
            <td class="subtextB">VAT AMOUNT</td>
            <td class="center gray">
                <table class="tablaAnidada">
                    <tr>
                        <td>
                            $
                        </td>
                        <td class="right">
                            <?php echo number_format($IVA, 4) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="text">
            <td>TOTAL AMOUNT</td>
            <td class="center gray">
                <table class="tablaAnidada">
                    <tr>
                        <td>
                            $
                        </td>
                        <td class="right">
                            <?php echo number_format($data[0]['total'], 4) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <span class="subtextB">OTHER COMMENTS OR SPECIAL INSTRUCTIONS / INCOTERM</span>
    <table class="comments">
        <tr>
            <td class="gray">
                <div style="height: 27px; padding:3px">
                    <?php echo mb_strtoupper($data[0]['otherComments']) ?>
                </div>
            </td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 5px;">
        <tr>
            <td>
                *********************
            </td>
            <td class="subtext" width="25%"> PAYMENT WILL BE IN CURRENCY</td>
            <td class="subtext gray center" style="border: 1px solid black;"><?php echo mb_strtoupper($data[0]['divisa']) ?></td>
            <td class="right">*********************</td>
        </tr>
    </table>
    <div>
        <span class="subtext">
            PASSMEX Part # must appear on all packages, labels & correspondence. <br>
            Purchase Order Number must appear on Invoices, Bills of Landing, Packaging Lists and Correspondence. <br>
            Invoice each Purchase Order separately and send invoice to your direct buyer to ensure payment. <br>
            Detailed packaging list must accompany all shipments. <br>
            If shipment is made to destination other than the Issuer of this Purchase Order, furnish Notification of Shipment to Purchasing Department.
        </span>
    </div>
    <div class="center">
        <span class="subtext">
            <br>
            PURCHASE ORDER TERMS AND CONDITIONS
        </span>
    </div>
    <div>
        <span class="subtext">
            Please see www.pass.de for Purchase Order Terms and Conditions, which are incorporated in, and made a part of, this Purchase Order ("Order"). This <br>
            order is an offer to Seller by Buyer for the purchase of goods and services ("Supplies"). This order does not constitute an acceptance of any offer or proposal made by Seller. <br>
            Any reference in this Order to any offer or proposal made by Seller is solely to incorporate the description or specifications of the Supplies in the prior offer or proposal, <br>
            but only to the extent that the description or specifications do not conflict with the description and specifications of the Supplies in this Order. Seller's written acceptance, <br>
            Seller's commencement of any work under this Order, or any other conduct by Seller that recognizes the existence of a contract with respect to the subject matter of this <br>
            Order constitutes Seller's acceptance of these Purchase Order Terms and Conditions only.
        </span>
    </div>
    <div class="subtext">
        <p>
            INFORMACIÓN CONFIDENCIAL. Este documento electrónico es totalmente confidencial en los términos del artículo 82, 83, 84 y 85 de la Ley de la Propiedad Industrial, <br>
            está dirigido exclusivamente, y tiene la intención de ser enviado a las personas que aparecen en el mismo como destinatarios.
        </p>
    </div>
    <div>
        <span class="subtextB">
            THIS ORDER EXPRESSLY LIMITS ACCEPTANCE TO THE TERMS OF THIS ORDER AND ANY ADDITIONAL OR DIFFERENT TERMS, WHETHER <br>
            CONTAINED IN SELLER'S QUOTATION FORM, ACKNOWLEDGEMENT FORM, INVOICE OR OTHERWISE, ARE UNACCEPTABLE TO BUYER AND <br>
            EXPRESSLY REJECTED BY BUYER, AND SHALL NOT BECOME PART OF THIS ORDER.
        </span>
    </div>
    <div class="center subtext">
        <span>
            <br>
            SGC REV. 1 <br>
            06/10/2017
        </span>
    </div>
</body>

</html>


<?php

$html = ob_get_clean();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();
$dompdf->stream("PurchaseOrder_ID" . $_GET["idPO"] . ".pdf", array("Attachment" => false));
?>