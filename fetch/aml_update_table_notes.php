<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

if(isset($_POST['pk']))
{
 global $wpdb;

 update_post_meta( $_POST['pk'], 'table_notes', $_POST['value'] );
 exit;
}
?>