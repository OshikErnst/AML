<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
global $wpdb;

 $logs = $wpdb->get_results( "SELECT * FROM aml_log order by ID DESC");

 echo json_encode($logs);
 exit;

?>