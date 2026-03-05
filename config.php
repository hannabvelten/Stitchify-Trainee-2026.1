<?php

return [
    'database' => [
        'name' => 'codejr_db',
        'username' => 'root',
        'password' => 'root',
        'connection' => 'mysql:host=db',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];