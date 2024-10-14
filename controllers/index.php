<?php

use Core\Database;

$config = require base_path('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

// prepare the query
$q = '
SELECT
    invoices.id,
    invoices.number,
    invoices.date,
    invoices.total,
    clients.company_name

FROM invoices
JOIN clients ON invoices.client_id = clients.id
ORDER BY invoices.date DESC;
';

// fetch all invoices
$invoices = $db->query($q)->fetchAll(PDO::FETCH_ASSOC);
// var_dump($invoices);

// return the selected view with data
view('index.view.php', [
    'heading' => 'Home',
    'invoices' => $invoices
]);
