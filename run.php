<?php
require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Spatie\DbDumper\Databases\PostgreSql;

# Getting config
$config = require('config.php');
$database_conf = $config['database'];
$log_conf = $config['log'];

# Check if log file exists. If not - create one
$full_file_name = $log_conf['path'] . '/' . 'week-' . date('W', time()) . '.log';
if (!file_exists($full_file_name)) {
    fopen($full_file_name, 'w');
}

# Initializing the logger
$Logger = new Logger('db-dumper');
$Logger->pushHandler(new StreamHandler($full_file_name, Logger::INFO));

# Dumping the DB
$Logger->info('Begin dump');
try {
    $Dumper = PostgreSql::create();
    $dump_name = $database_conf['database'] . '-' . strval(time()) . '.sql';

    $Dumper->setDbName($database_conf['database'])
        ->setUserName($database_conf['username'])
        ->setPassword($database_conf['password'])
        ->dumpToFile($database_conf['dump_folder'] . '/' . $dump_name);

    $Logger->info('Dump finished successfully!');
} catch (\Exception $e) {
    $Logger->error('Exception', array('exception' => $e));
    throw $e;
}