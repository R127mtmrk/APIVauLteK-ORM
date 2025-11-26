<?php

// Chargement helpers
require __DIR__ . '/helpers/Response.php';
require __DIR__ . '/helpers/Http.php';

// Config DB
require __DIR__ . '/config/database.php';

// ORM
require __DIR__ . '/orm/Request/Select.php';
require __DIR__ . '/orm/Request/Insert.php';
require __DIR__ . '/orm/Request/Update.php';
require __DIR__ . '/orm/Request/Delete.php';
require __DIR__ . '/orm/Request/TypeRequest.php';
require __DIR__ . '/orm/Request/DBManager.php';

// Routes Manager
require __DIR__ . '/routes/router.php';

// Autoload contrôleurs & services (simple)
spl_autoload_register(function($class) {
    $paths = ['controllers', 'services'];
    foreach ($paths as $dir) {
        $file = __DIR__ . "/$dir/$class.php";
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
