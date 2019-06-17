<?php
require_once 'bootstrap.php';

use DbDumper\Zip\DefaultZipper;

$conf_zip = $config['archive'];
# Compress DB dumps
$Logger->info('Begin compressing dumps');
try {
	
	$full_zip_name = $conf_zip['folder'] . '/' . 'dumps-week-' . date('W', time()) . '.zip';
//	if (!file_exists($full_file_name)) {
//		fopen($full_file_name, 'w');
//	}
	
	$zip = new DefaultZipper($full_zip_name);
	$found_files = $zip->addGlob($config['database']['dump_folder'] . '/dbk-*.sql');
	$Logger->info("numfiles: " . $zip->numFiles);
	$Logger->info("status:" . $zip->status);
	$zip->zip();
	
	foreach ($found_files as $file) {
		if (!unlink($file)) {
			$Logger->warning(sprintf('Could not delete a file %s', $file));
		}
	}
	
} catch (\Exception $e) {
	$Logger->error('Exception', array('exception' => $e));
	throw $e;
}