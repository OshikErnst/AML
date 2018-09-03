<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

//$formid = $_POST['formid'];
$formid = $_POST['formid'];
$cancelled_time = $_POST['cancelled_time'];
$cancelled_name = $_POST['cancelled_name'];
$cancelled_reason = $_POST['cancelled_reason'];
$cancelled_comments = $_POST['cancelled_comments'];
$LogType = $_POST['LogType']; //regular or international
$currentUser = $_POST['currentUser'];
$LogDate = date("d/m/Y");


update_post_meta( $formid, 'cancelled_time', $cancelled_time );
update_post_meta( $formid, 'cancelled_name', $cancelled_name );
update_post_meta( $formid, 'cancelled_reason', $cancelled_reason );
update_post_meta( $formid, 'cancelled_comments', $cancelled_comments );

$text_for_log = $cancelled_name .' ביטל/ה משלוח מספר '.$formid.' בשעה '.$cancelled_time.', סיבת הביטול: '.$cancelled_reason.', הערות לביטול: '.$cancelled_comments.'<br />User: '.$currentUser;


$wpdb->insert( 
	'aml_log', 
	array( 
        'Log' => $text_for_log,
        'LogType' => $LogType,
        'LogDate' => $LogDate,

	)
);



?>

