<?php
// dd($_POST);

use Core\Database;
use Core\Validator;

$config = require base_path('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

$errors = [];


// add form validation
if (!Validator::string($_POST['company_name'], 5, 100)) {
    $errors['company_name'] = 'La ragione sociale deve essere compresa tra 5 e 100 caratteri';
}
if (!Validator::string($_POST['address'], 5, 100)) {
    $errors['address'] = 'L\'indirizzo deve essere compreso tra 5 e 100 caratteri';
}
if (!Validator::string($_POST['vat_number'], 13, 13)) {
    $errors['vat_number'] = 'Inserire una P.IVA valida da 13 caratteri (includere IT)';
}

// check if the invoice number already exists in the db
$invoiceNumber = $_POST['invoice_number'];

$existingInvoice = $db->query('SELECT id FROM invoices WHERE number = :number', [
    'number' => $invoiceNumber
])->fetch();

if ($existingInvoice) {
    $errors['invoice_number'] = 'Il numero di fattura è già stato utilizzato.';
}

// in case of errors return errors variable 
if (!empty($errors)) {
    return view('invoices/create.view.php', [
        'heading' => 'Crea nuova fattura',
        'errors' => $errors,
    ]);
}

// dd($_POST);
// CLIENT

// check if the client is in the db
$existingClient = $db->query('SELECT id FROM clients WHERE company_name = :company_name AND vat_number = :vat_number', [
    'company_name' => $_POST['company_name'],
    'vat_number' => $_POST['vat_number']
])->fetch();
// var_dump($existingClient);

// if there is a correspondecy 
// use the existing client id to populate
// the variable for the FK
if ($existingClient) {
    $clientId = $existingClient['id'];
} else {
    // create a new client
    $db->query('INSERT INTO clients(company_name, address, vat_number) VALUES(:company_name, :address, :vat_number)', [
        'company_name' => $_POST['company_name'],
        'address' => $_POST['address'],
        'vat_number' => $_POST['vat_number']
    ]);
    // get last client id
    $clientId = $db->lastInsertId();
}

// END CLIENT


// INVOICE and INVOICE ITEMS

// format date
$date = date('Y-m-d', strtotime($_POST['date']));


if (empty($errors)) {
    // add invoice to db
    $db->query('INSERT INTO invoices(client_id, date, number, total, taxable_amount) VALUES(:client_id, :date, :number, :total, :taxable_amount)', [
        'client_id' => $clientId,
        'date' => $date,
        'number' => $_POST['invoice_number'],
        'total' => $_POST['invoice_total'],
        'taxable_amount' => $_POST['taxable_amount'],
    ]);
    // get last invoice id
    $invoiceId = $db->lastInsertId();

    // filter data to avoid empty strings
    $invoiceDetails = $_POST['invoice_details'];

    // remove empty strings, if any
    $filteredDetails = array_filter($invoiceDetails, function ($detail) {
        return !empty($detail['description']) && !empty($detail['price']) && !empty($detail['quantity']);
    });

    // add invoice details to db for each row in the invoice
    foreach ($filteredDetails as $row) {
        // convert to correct decimal value for db storage
        $subtotal = floatval(str_replace(',', '.', str_replace('€', '', $row['subtotal'])));
        // dd($subtotal);

        $db->query('INSERT INTO invoice_details(invoice_id, description, quantity, price, subtotal) VALUES(:invoice_id, :description, :quantity, :price, :subtotal)', [
            'invoice_id' => $invoiceId,
            'description' => $row['description'],
            'quantity' => $row['quantity'],
            'price' => $row['price'],
            'subtotal' => $subtotal,
        ]);
    }

    header('location: /');
    die();
}
