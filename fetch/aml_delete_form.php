<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['form_id']))
{
 global $wpdb;
 wp_delete_post( $_POST['form_id'] );
 
 exit;
}
?>