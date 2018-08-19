<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option']))
{
 global $wpdb;

$couriers = $wpdb->get_row( "SELECT * FROM aml_couriers where ID = " . $_POST['get_option']);

echo $couriers->email;

 exit;
}
?>