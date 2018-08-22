<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

if($_POST['formid'] != "0"){
$formid = $_POST['formid'];
}
$currentTime = $_POST['currentTime'];
$currentUser = $_POST['currentUser'];
$currentDifference = $_POST['currentDifference'];

/*foreach ($currentDifference as $value) {
    $Differencevalue = $value * 2;
}*/

$groupedDifference = implode(',', $currentDifference);

$LogType = $_POST['LogType']; //regular or international OR admin page
$LogDate = date("d/m/Y");


if($_POST['formid'] != "0"){
	$text_for_log = $currentUser .' עדכן/נה משלוח מספר '. $formid .' בשעה '.$currentTime.'<br /> שינויים:<br />'.urldecode($groupedDifference);
}else{
	$text_for_log = $currentUser .' עדכן/נה בשעה '.$currentTime.'<br /><strong> שינויים:</strong><br />'.urldecode($groupedDifference);
}	



$wpdb->insert( 
	'aml_log', 
	array( 
        'Log' => $text_for_log,
        'LogType' => $LogType,
        'LogDate' => $LogDate,
        'LogDifference' => urldecode($groupedDifference)

	)
);



?>

