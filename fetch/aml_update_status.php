<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['form_id']))
{
 global $wpdb;

 update_post_meta( $_POST['form_id'], 'status', $_POST['status_val'] );
 exit;
}
?>