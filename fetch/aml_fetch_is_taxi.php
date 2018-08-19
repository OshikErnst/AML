<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option'])){
 global $wpdb;

 $is_taxi = $wpdb->get_row( "SELECT taxi FROM aml_pickup_types where ID = " . $_POST['get_option']);
 	echo $is_taxi->taxi;
}
?>