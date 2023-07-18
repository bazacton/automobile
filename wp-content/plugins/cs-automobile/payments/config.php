<?php
/**
 *  File Type: Payment Configuration
 *
 */
 
 $dir = automobile_var::plugin_path().'/payments/gateways/';
 $dh = opendir($dir);
 if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			if( $ext == 'php' ) {
				include(automobile_var::plugin_path().'/payments/gateways/'.$file);
			}
		}
		closedir($dh);
	}
 }
 
?>