<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

require dirname(__FILE__) . '/PHPMailer/src/Exception.php';
require dirname(__FILE__) . '/PHPMailer/src/PHPMailer.php';
require dirname(__FILE__) . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true); 
$mail->isSMTP();
$mail->Host = 'outlook.office365.com';
$mail->SMTPAuth = true;
$mail->Username = 'deliveries@aml.co.il';
$mail->Password = 'Dd123456';
$mail->SMTPSecure = 'tls';

$mail->setFrom('deliveries@aml.co.il', 'AML');

global $wpdb;

$formID = $_REQUEST['formID'];
$formLang = $_REQUEST['formLang'];




if($formLang=='1'){

$cur_email = get_post_meta( $formID, 'courier_email', true );

$cur_ctcodes = get_post_meta( $formID, 'ctcodes', true );
$mail_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $cur_ctcodes);

$cur_sites = get_post_meta( $formID, 'sites', true );
$mail_sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $cur_sites);

$cur_department = get_post_meta( $formID, 'department', true );

$cur_zone = get_post_meta( $formID, 'zone', true );
$mail_zone = $wpdb->get_row( "SELECT * FROM aml_zones where ID = " . $cur_zone);

$cur_courier = get_post_meta( $formID, 'courier', true );
$mail_courier = $wpdb->get_row( "SELECT * FROM aml_couriers where ID = " . $cur_courier);

$cur_contact = get_post_meta( $formID, 'contact', true );

$cur_address = get_post_meta( $formID, 'address', true );

$cur_phone = get_post_meta( $formID, 'phone', true );

$cur_pickup = get_post_meta( $formID, 'pickup', true );
$mail_pickup = $wpdb->get_row( "SELECT * FROM aml_pickup_types where ID = " . $cur_pickup);

$cur_targets = get_post_meta( $formID, 'targets', true );
$mail_target = $wpdb->get_row( "SELECT * FROM aml_targets where ID = " . $cur_targets);

$cur_date = get_post_meta( $formID, 'date', true );

$cur_taxi_hour = get_post_meta( $formID, 'taxi_hour', true );
$cur_taxi_mins = get_post_meta( $formID, 'taxi_mins', true );
$cur_hour_from = get_post_meta( $formID, 'hour_from', true );
$cur_hour_to = get_post_meta( $formID, 'hour_to', true );

$cur_notes = get_post_meta( $formID, 'notes', true );

$cur_visits = get_post_meta($formID,'visits',true);
$mail_visits = unserialize($cur_visits);
    foreach ( $mail_visits as $term ) {
        $the_visits = $wpdb->get_row( "SELECT name FROM aml_visits where ID = " . $term);
        $cur_visit .= $the_visits->name . ' / ';


    }

$username = get_post_field( 'post_author', $formID );



/**/	
$subject = 'ביטול הזמנת שליחות  - '. $mail_ct_code->name;

$content = 'נבקשכם לבטל את השליחות הבאה::<br /><br /><table cellpadding=10 cellspasing=10><tr><td>מחקר</td><td style="direction:rtl;text-align:center;">'.$mail_ct_code->name.'</td><td>Study name</td></tr><tr><td>בית חולים</td><td style="direction:rtl;text-align:center;">'.$mail_sites->name.' - '.$mail_sites->department.'</td><td>Hospital</td></tr><tr><td>מחלקה</td><td style="direction:rtl;text-align:center;">'.$cur_department.'</td><td>Department</td></tr><tr><td>אזור בארץ</td><td style="direction:rtl;text-align:center;">'.$mail_zone->name.'</td><td>zone</td></tr><tr><td>חברת הובלה</td><td style="direction:rtl;text-align:center;">'.$mail_courier->name.'</td><td>courier</td></tr><tr><td>איש קשר</td><td style="direction:rtl;text-align:center;">'.$cur_contact.'</td><td>Contact person</td></tr><tr><td>כתובת איסוף</td><td style="direction:rtl;text-align:center;">'.$cur_address.'</td><td>Pickup Address</td></tr><tr><td>טלפון</td><td style="text-align:center;">'.$cur_phone.'</td><td>Tel Number</td></tr><tr><td>סוג איסוף</td><td style="direction:rtl;text-align:center;">'.$mail_pickup->name.'</td><td>Kind of shipment</td></tr><tr><td>יעד המשלוח</td><td style="direction:rtl;text-align:center;">'.$mail_target->address.'</td><td>shipment target</td></tr><tr><td>תאריך איסוף</td><td style="text-align:center;">'.$cur_date.'</td><td>Inbound shipment(Date)</td></tr><tr><td>שעות איסוף</td><td style="text-align:center;">'.$hour_from.'-'.$hour_to.' / '.$taxi_hour.':'.$taxi_mins.'</td><td>Time of shipment</td></tr><tr><td>הערות</td><td style="direction:rtl;text-align:center;">'.$cur_notes.'</td><td>Comment</td></tr><tr><td>ביקור</td><td style="text-align:center;">'.$cur_visit.'</td><td>Visit</td></tr><tr><td>הוזמן על ידי</td><td style="text-align:center;">'.$username.'</td><td>ordered by</td></tr><tr><td>מספר הזמנה</td><td style="text-align:center;">'.$formID.'</td><td>Order Num</td></tr></table>';


}else{

setup_postdata( $formID );

$cur_ctcodes = get_post_meta( $formID, 'ctcodes', true );
$mail_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $cur_ctcodes);

$cur_int_targets = get_post_meta( $formID, 'int_targets', true );
$mail_int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where ID = " . $cur_int_targets);

$cur_shipment_number = get_post_meta( $formID, 'shipment_number', true );
$cur_outbound_shipment_date = get_post_meta( $formID, 'outbound_shipment_date', true );

$cur_hour_from = get_post_meta( $formID, 'hour_from', true );
$cur_hour_to = get_post_meta( $formID, 'hour_to', true );

$mail_hour_from = $cur_hour_from.':00';
$mail_hour_to = $cur_hour_to.':00';
$mail_hours = $mail_hour_from . '-' . $mail_hour_to;

$cur_world_courier = get_post_meta( $formID, 'world_courier', true );
$mail_courier = $wpdb->get_row( "SELECT * FROM aml_world_couriers where ID = " . $cur_world_courier);

$cur_shipping_type = get_post_meta( $formID, 'shipping_type', true );
$mail_shipping_type = $wpdb->get_row( "SELECT * FROM aml_shipping_types where ID = " . $cur_shipping_type);

$cur_email = $mail_courier->email;


$subject = 'Delivery Cancellation ['.$mail_ct_code->name.'] ['.$mail_shipping_type->name.'] ['.$mail_int_targets->name.']';

$content = 'Please cancel the following pickup: <br /><br /><table cellpadding=10 cellspasing=10> <tr> <td>מחקר</td><td>'.$mail_ct_code->name.'</td><td>Clinical Trial</td></tr><tr> <td>יעד משלוח</td><td>'.$mail_int_targets->name.'</td><td>Destination of shipment</td></tr><tr> <td>מספר משלוח</td><td>'.$cur_shipment_number.'</td><td>Shipment Number</td></tr><tr> <td>תאריך משלוח</td><td>'.$cur_outbound_shipment_date.'</td><td>Outbound shipment date</td></tr><tr> <td>שעת איסוף</td><td>'.$mail_hours.'</td><td>Pickup time</td></tr><tr> <td>חברת שילוח</td><td>'.$mail_courier->name.'</td><td>Courier</td></tr><tr> <td>סוג משלוח</td><td>'.$mail_shipping_type->name.'</td><td>Shipping Type</td></tr><tr> <td>--- </td><td>contact us&nbsp;ליצירת קשר  </td><td>--- </td></tr><tr> <td>---</td><td>amlcustserv@aml.co.il</td><td>---</td></tr><tr> <td>---</td><td>099561268</td><td>---</td></tr><tr><td>מספר הזמנה</td><td style="text-align:center;">'.$formID.'</td><td>Order Num</td></tr></table>';
}


//clean and split to different emails

trim($cur_email);
$array = explode(',', $cur_email); //split string into array seperated by ', '
foreach($array as $value) //loop over values
{

    $mail->AddBCC($value, $value); 
}


$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = $subject ;
$mail->Body    = $content;

$mail->send();