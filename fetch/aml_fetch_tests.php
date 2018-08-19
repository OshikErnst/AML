<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option'])){
 global $wpdb;

 $visits = $wpdb->get_results( "SELECT id,name
FROM aml_tests
INNER JOIN aml_ct_tests ON aml_tests.ID = aml_ct_tests.test_id
WHERE ct_id = " .  $_POST['get_option']);

 echo json_encode($visits);
}
?>