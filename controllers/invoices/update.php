<?php
// dd($_POST);

use Core\Database;
use Core\Validator;

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
    invoices.client_id AS client_id,

    clients.company_name,
    clients.address,
    clients.vat_number

FROM invoices
JOIN clients ON invoices.client_id = clients.id
WHERE invoices.id = :invoice_id
ORDER BY invoices.date DESC;
';

// get invoice id
$id = $_POST['id'];

// fetch the selected invoice
$invoice = $db->query($q, [
    'invoice_id' => $id
])->fetch(PDO::FETCH_ASSOC);
// dd($invoice);

$client_id = $invoice['client_id'];

// prepare the query to get invoice details
$qdetails = '
SELECT
    invoice_details.id,
    invoice_details.description,
    invoice_details.quantity,
    invoice_details.price,
    invoice_details.subtotal
FROM invoice_details
WHERE invoice_details.invoice_id = :invoice_id;
';

// fetch the invoice details
$invoice_details = $db->query($qdetails, [
    'invoice_id' => $id
])->fetchAll(PDO::FETCH_ASSOC);
// dd($invoice_details);

// add form validation
$errors = [];

if (!Validator::string($_POST['company_name'], 5, 100)) {
    $errors['company_name'] = 'La ragione sociale deve essere compresa tra 5 e 100 caratteri';
}
if (!Validator::string($_POST['address'], 5, 100)) {
    $errors['address'] = 'L\'indirizzo deve essere compreso tra 5 e 100 caratteri';
}
if (!Validator::string($_POST['vat_number'], 13, 13)) {
    $errors['vat_number'] = 'Inserire una P.IVA valida da 13 caratteri (includere IT)';
}

// in case of errors return the view with errors to be displayed
if (!empty($errors)) {
    return view('invoices/edit.view.php', [
        'heading' => 'Modifica fattura di vendita n. ' . $invoice['number'] . ' del ' . date('d-m-Y', strtotime($invoice['date'])),
        'errors' => $errors,
        'invoice' => $invoice,
        'details' => $invoice_details
    ]);
}

// if no validation errors, update the db
// prepare the query
$invoices_query = '
UPDATE invoices
SET
    invoices.date = :invoice_date,
    invoices.number = :invoice_number,
    invoices.total = :invoice_total,
    invoices.taxable_amount = :invoice_taxable_amount
WHERE invoices.id = :invoice_id;
';

$clients_query = '
UPDATE clients
SET
    clients.company_name = :client_company_name,
    clients.address = :client_address,
    clients.vat_number = :client_vat_number
WHERE clients.id = :invoice_client_id;
';

$details_query = '
    INSERT INTO invoice_details (invoice_id, description, quantity, price, subtotal)
    VALUES (:invoice_id, :invoice_details_description, :invoice_details_quantity, :invoice_details_price, :invoice_details_subtotal)
    ON DUPLICATE KEY UPDATE
        quantity = VALUES(quantity),
        price = VALUES(price),
        subtotal = VALUES(subtotal);
';


// update invoices
$invoice = $db->query($invoices_query, [
    'invoice_id' => $id,
    'invoice_date' => $_POST['date'],
    'invoice_number' => $_POST['invoice_number'],
    'invoice_total' => $_POST['invoice_total'],
    'invoice_taxable_amount' => $_POST['taxable_amount']
]);

// update clients
$invoice = $db->query($clients_query, [
    'client_company_name' => $_POST['company_name'],
    'client_address' => $_POST['address'],
    'client_vat_number' => $_POST['vat_number'],
    'invoice_client_id' => $client_id
]);

// update invoice details
// db data -> $invoice_details
// form data
$invoiceDetails = $_POST['invoice_details'];

foreach ($invoice_details as $dbDetail) {
    // check if the id is in the db
    $isFound = false;
    foreach ($invoiceDetails as $formDetail) {
        if ($formDetail['description'] === $dbDetail['description']) {
            $isFound = true;
        }
    }

    // if not found, delete from db
    if (!$isFound) {
        $delete_query = '
            DELETE FROM invoice_details
            WHERE id = :id;
        ';
        $db->query($delete_query, [
            'id' => $dbDetail['id']
        ]);
    }
};

// if found, add or update
foreach ($invoiceDetails as $row) {

    $db->query($details_query, [
        'invoice_id' => $id,
        'invoice_details_description' => $row['description'],
        'invoice_details_quantity' => $row['quantity'],
        'invoice_details_price' => $row['price'],
        'invoice_details_subtotal' => $row['subtotal']
    ]);
}

header(('location: /'));
die();
