<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option'])){
 global $wpdb;

 $visits = $wpdb->get_results( "SELECT id,name
FROM aml_int_targets
INNER JOIN aml_ct_int_targets ON aml_int_targets.ID = aml_ct_int_targets.int_target
WHERE ct_id = " .  $_POST['get_option']);

 echo json_encode($visits);
}
?>