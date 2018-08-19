<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['formid'])){
 global $wpdb;


 $cancelled_all = array();
 $cancelled_time = get_post_meta( $_POST['formid'] , 'cancelled_time', true );
 $cancelled_name = get_post_meta( $_POST['formid'] , 'cancelled_name', true );
 $cancelled_reason = get_post_meta( $_POST['formid'] , 'cancelled_reason', true );
 $cancelled_comments = get_post_meta( $_POST['formid'] , 'cancelled_comments', true );


 array_push($cancelled_all, array('cancelled_time' => $cancelled_time));
 array_push($cancelled_all, array('cancelled_name' => $cancelled_name));
 array_push($cancelled_all, array('cancelled_reason' => $cancelled_reason));
 array_push($cancelled_all, array('cancelled_comments' => $cancelled_comments));


 echo json_encode($cancelled_all);

}
?>