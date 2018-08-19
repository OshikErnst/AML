<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option'])){
 global $wpdb;

 $visits = $wpdb->get_results( "SELECT ID,name FROM aml_visits where clinical_trial = " . $_POST['get_option']);
 echo json_encode($visits);
}
?>