<?php

use Core\Database;

$config = require base_path('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

// prepare the query
$q = '
SELECT 
    invoices.id,
    invoices.date,
    invoices.number,
    invoices.total,
    invoices.taxable_amount,
    
    clients.company_name,
    clients.address,
    clients.vat_number

FROM invoices
JOIN clients ON invoices.client_id = clients.id
WHERE invoices.id = :invoice_id
ORDER BY invoices.date DESC;
';

// get invoice id
$id = $_GET['id'];

// fetch the selected invoice
$invoice = $db->query($q, [
    ':invoice_id' => $id
])->fetch(PDO::FETCH_ASSOC);
// var_dump($invoice);

// prepare the query to get invoice details
$qdetails = '
SELECT
    invoice_details.description,
    invoice_details.quantity,
    invoice_details.price,
    invoice_details.subtotal
FROM invoice_details
WHERE invoice_details.invoice_id = :invoice_id;
';

// fetch the invoice details
$invoice_details = $db->query($qdetails, [
    ':invoice_id' => $id
])->fetchAll(PDO::FETCH_ASSOC);
// var_dump($invoice_details);


// return the selected view with data
view('invoices/show.view.php', [
    'heading' => 'Fattura di vendita n. ' . $invoice['number'] . ' del ' . date('d-m-Y', strtotime($invoice['date'])),
    'invoice' => $invoice,
    'details' => $invoice_details
]);
