<?php

$errors = [];

// return the selected view with data
view('invoices/create.view.php', [
    'heading' => 'Crea nuova fattura',
    'errors' => $errors
]);
