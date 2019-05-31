<?php

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

return [
    'database' => [
        'driver' => getenv('DATABASE_DRIVER'),
        'database' => getenv('DATABASE_NAME'),
        'username' => getenv('DATABASE_USERNAME'),
        'password' => getenv('DATABASE_PASSWORD'),
        'dump_folder' => getenv('DUMP_FOLDER'),
    ],

    'log' => [
        'path' => getenv('LOG_PATH')
    ]
];