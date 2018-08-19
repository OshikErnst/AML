<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

//$formid = $_POST['formid'];
$formid = $_POST['formid'];
$received_time = $_POST['received_time'];
$received_sender_name = $_POST['received_sender_name'];
$received_receiver_name = $_POST['received_receiver_name'];
$received_comments = $_POST['received_comments'];
$LogType = $_POST['LogType']; //regular or international
$LogDate = date("d/m/Y");


update_post_meta( $formid, 'received_time', $received_time );
update_post_meta( $formid, 'received_sender_name', $received_sender_name );
update_post_meta( $formid, 'received_receiver_name', $received_receiver_name );
update_post_meta( $formid, 'received_comments', $received_comments );


switch ($_POST['actionType']) {
	case 'התקבל':
		$actionType = 'קיבל/ה משלוח';
		break;
	case 'נשלח':
		$actionType = 'שלח/ה משלוח';
		break;
	default:
		$actionType = '';	
		break;
}





$text_for_log = $received_receiver_name . ' ' . $actionType . ' מספר '.$formid.' בשעה '.$received_time.', שם השליח: '.$received_sender_name.', הערות לקבלת המשלוח: '.$received_comments;


$wpdb->insert( 
	'aml_log', 
	array( 
        'Log' => $text_for_log,
        'LogType' => $LogType,
        'LogDate' => $LogDate,

	)
);

echo $wpdb->last_query;
echo $wpdb->last_error ;

?>