<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option'])){
 global $wpdb;

 $time_limit = $wpdb->get_row( "SELECT time_limit FROM aml_sites where ID = " . $_POST['get_option']);
 	echo $time_limit->time_limit;
}
?>