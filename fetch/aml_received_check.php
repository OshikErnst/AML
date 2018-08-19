<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
if(isset($_POST['formid'])){
 global $wpdb;


 $received_all = array();
 $received_time = get_post_meta( $_POST['formid'] , 'received_time', true );
 $received_sender_name = get_post_meta( $_POST['formid'] , 'received_sender_name', true );
 $received_receiver_name = get_post_meta( $_POST['formid'] , 'received_receiver_name', true );
 $received_comments = get_post_meta( $_POST['formid'] , 'received_comments', true );


 array_push($received_all, array('received_time' => $received_time));
 array_push($received_all, array('received_sender_name' => $received_sender_name));
 array_push($received_all, array('received_receiver_name' => $received_receiver_name));
 array_push($received_all, array('received_comments' => $received_comments));


 echo json_encode($received_all);

}
?>