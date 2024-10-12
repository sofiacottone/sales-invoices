<?php

use Core\Database;

$config = require base_path('config.php');

// create a new database instance with the configuration data
$db = new Database($config['database']);

// return the selected view with data
view('index.view.php', [
    'heading' => 'Home',
]);
