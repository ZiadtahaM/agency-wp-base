<?php
require_once 'C:/Users/DevUser/.local-wp/wordpress/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/export.php';

ob_start();
export_wp(array('content' => 'all'));
$xml = ob_get_clean();

$dest = 'C:/Users/DevUser/agency-wp-base/falso-content-export.xml';
file_put_contents($dest, $xml);
echo "Export saved to: $dest\n";
echo "Size: " . strlen($xml) . " bytes\n";
