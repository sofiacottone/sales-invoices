<?php

require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// get variables
$company_name = $_POST['company_name'];
$vat_number = $_POST['vat_number'];
$address = $_POST['address'];
$invoice_number = $_POST['invoice_number'];
$date = date('d-m-Y', strtotime($_POST['date']));
$invoice_total = $_POST['invoice_total'];
$taxable_amount = $_POST['taxable_amount'];
$vat_rate = $_POST['vat_rate'];

$invoice_details = $_POST['invoice_details'];

$row = '';

foreach ($invoice_details as $detail) {
    $row .= '<tr>';
    $row .= '<td>' . $detail["description"] . '</td>';
    $row .= '<td>' . $detail["price"] . '€' . '</td>';
    $row .= '<td>' . $detail["quantity"] . '</td>';
    $row .= '<td>' . $detail["subtotal"] . '€' . '</td>';
    $row .= '<tr>';
};

// set options
$options = new Options;
$options->setChroot(__DIR__);

// create a new instance of the dompdf class with options
$dompdf = new Dompdf($options);

// set the paper size and orientation
$dompdf->setPaper('A4', 'vertical');

// load the html file
$html = file_get_contents('invoice.html');

$html = str_replace(["{company_name}", "{vat_rate}", "{address}", "{invoice_number}", "{date}", "{invoice_total}", "{taxable_amount}", "{vat_number}", "{row}"], [$company_name, $vat_rate, $address, $invoice_number, $date, $invoice_total, $taxable_amount, $vat_number, $row], $html);

$dompdf->loadHtml($html);

// render the HTML as PDF
$dompdf->render();

// send the PDF to the browser
$dompdf->stream('invoice.pdf', ['Attachment' => 0]);
