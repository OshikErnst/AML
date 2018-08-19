<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['get_option']))
{
 global $wpdb;
echo $_POST['get_option'];
$sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $_POST['get_option']);

echo $sites->address;

 exit;
}
?>