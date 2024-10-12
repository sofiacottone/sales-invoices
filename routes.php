<?php

$router->get('/', 'controllers/index.php');
$router->get('/invoice', 'controllers/invoices/show.php');

$router->get('/invoices/create', 'controllers/invoices/create.php');
$router->post('/invoices', 'controllers/invoices/store.php');

$router->get('/invoice/edit', 'controllers/invoices/edit.php');
$router->post('/invoice', 'controllers/invoices/update.php');
