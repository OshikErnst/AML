<?php 
/**
 * Template Name: Int Form page
 *
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

include('aml_checklogin.php');
/* Get user info. */
global $wp_roles,$wpdb;
$user_info = get_currentuserinfo();


$error = array();    
/* If profile was saved, update profile. */

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && ($_POST['action'] == 'update-form' || $_POST['action'] == 'update-send-form' )) {    

   $the_post_id = $_GET['formid'];
    
    if(current_user_can('administrator')){

    if($_POST['ctcodes']){
        update_post_meta( $the_post_id, 'ctcodes', $_POST['ctcodes'] );
    }
    update_post_meta( $the_post_id, 'int_targets', $_POST['int_targets'] );
    update_post_meta( $the_post_id, 'awb', $_POST['awb'] );
    update_post_meta( $the_post_id, 'shipment_number', $_POST['shipment_number'] );
    update_post_meta( $the_post_id, 'outbound_shipment_date', $_POST['outbound_shipment_date'] );

    update_post_meta( $the_post_id, 'hour_from', $_POST['hour_from'] );
    update_post_meta( $the_post_id, 'hour_to', $_POST['hour_to'] );

    update_post_meta( $the_post_id, 'world_courier', $_POST['world_courier'] );
    update_post_meta( $the_post_id, 'shipping_type', $_POST['shipping_type'] );
    }//if admin

    update_post_meta( $the_post_id, 'tube_number', $_POST['tube_number'] );
    update_post_meta( $the_post_id, 'tests', $_POST['tests'] );

    update_post_meta( $the_post_id, 'status', $_POST['status'] );    


    if ($_POST['action'] == 'update-send-form'){
   

    $mail_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $_POST['ctcodes']);
    $mail_int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where ID = " . $_POST['int_targets']);
    $mail_courier = $wpdb->get_row( "SELECT * FROM aml_world_couriers where ID = " . $_POST['world_courier']);
    $mail_shipping_type = $wpdb->get_row( "SELECT * FROM aml_shipping_types where ID = " . $_POST['shipping_type']);

    $mail_hour_from = $_POST['hour_from'].':00';
    $mail_hour_to = $_POST['hour_to'].':00';
    $mail_hours = $mail_hour_from . '-' . $mail_hour_to;


    /* EMAIL */

   $message = 'We would like to order a pickup with the following details: <br /><br /><table cellpadding=10 cellspasing=10> <tr> <td>מחקר</td><td>'.$mail_ct_code->name.'</td><td>Clinical Trial</td></tr><tr> <td>יעד משלוח</td><td>'.$mail_int_targets->name.'</td><td>Destination of shipment</td></tr><tr> <td>מספר משלוח</td><td>'.$_POST['shipment_number'].'</td><td>Shipment Number</td></tr><tr> <td>תאריך משלוח</td><td>'.$_POST['outbound_shipment_date'].'</td><td>Outbound shipment date</td></tr><tr> <td>שעת איסוף</td><td>'.$mail_hours.'</td><td>Pickup time</td></tr><tr> <td>חברת שילוח</td><td>'.$mail_courier->name.'</td><td>Courier</td></tr><tr> <td>סוג משלוח</td><td>'.$mail_shipping_type->name.'</td><td>Shipping Type</td></tr><tr> <td>--- </td><td>contact us&nbsp;ליצירת קשר  </td><td>--- </td></tr><tr> <td>---</td><td>amlcustserv@aml.co.il</td><td>User Email</td></tr><tr> <td>---</td><td>099561268</td><td>---</td></tr><tr><td>מספר הזמנה</td><td style="text-align:center;">'.$the_post_id.'</td><td>Order Num</td></tr></table>';



    //echo $content;

    require dirname(__FILE__) . '/PHPMailer/src/Exception.php';
    require dirname(__FILE__) . '/PHPMailer/src/PHPMailer.php';
    require dirname(__FILE__) . '/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true); 
    $mail->isSMTP();
    $mail->Host = 'outlook.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'deliveries@aml.co.il';
    $mail->Password = 'GhErBM19@#';
    $mail->SMTPSecure = 'tls';

    $mail->setFrom('deliveries@aml.co.il', 'AML');

        
    //clean and split to different emails
    $courier_email = $mail_courier->email;
    trim($courier_email);
    $array = explode(',', $courier_email); //split string into array seperated by ', '
        foreach($array as $value) //loop over values
        {
            $mail->AddBCC($value, $value); 
        }
    

    if (isset($_FILES['file_attached']) && $_FILES['file_attached']['error'] == UPLOAD_ERR_OK) {
        $mail->AddAttachment(
            $_FILES['file_attached']['tmp_name'],
            $_FILES['file_attached']['name']
        );
    }


    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Delivery request from AML :" . $mail_ct_code->name ." - ". $mail_shipping_type->name ." - ". $mail_int_targets->name;
    $mail->Body    = $message;

    $mail->send();
    
    
    }//end if sending mail
   

    wp_redirect( $_SERVER['REQUEST_URI'].'&sent=true' ); exit;
   
}


get_header();

?>

<body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <?php include('aml_header.php');?>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <?php include('aml_menu.php');?>

            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">

                                <div>
                                    <h4 class="page-title">Int Form</h4>
                                    

                                    
                                </div>
                                
                                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <div id="post-<?php the_ID(); ?>">
                                    <div class="entry-content entry">
                                    <?php if ( $_GET['sent'] == 'true' ) : ?> <div id="message" class="text-success"><p>form updated</p></div> <?php endif; ?>

                                    <form method="post" id="updateform" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >

                                    <?php
                                    global $post,$wpdb;
                                    $post = get_post( $_GET['formid'] );
                                    setup_postdata( $post );

                                    $userid = get_the_author_meta('ID');

                                    $cur_creation_date = get_post_meta( get_the_ID(), 'creation_date', true );

                                    $cur_ctcodes = get_post_meta( get_the_ID(), 'ctcodes', true );

                                    $ct_code_name = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $cur_ctcodes);

                                    $cur_int_targets = get_post_meta( get_the_ID(), 'int_targets', true );
                                    $cur_awb = get_post_meta( get_the_ID(), 'awb', true );
                                    $cur_shipment_number = get_post_meta( get_the_ID(), 'shipment_number', true );
                                    $cur_outbound_shipment_date = get_post_meta( get_the_ID(), 'outbound_shipment_date', true );

                                    $cur_hour_from = get_post_meta( get_the_ID(), 'hour_from', true );
                                    $cur_hour_to = get_post_meta( get_the_ID(), 'hour_to', true );

                                    $cur_world_courier = get_post_meta( get_the_ID(), 'world_courier', true );
                                    $cur_shipping_type = get_post_meta( get_the_ID(), 'shipping_type', true );

                                    $cur_tube_number = get_post_meta( get_the_ID(), 'tube_number', true );
                                    $cur_tests = get_post_meta( get_the_ID(), 'tests', true );

                                    $cur_status = get_post_meta( get_the_ID(), 'status', true );

                                    ?>
                    
                                    <?php
                                    if($cur_creation_date){
                                        echo '<p style="font-size:18px;margin-bottom:20px;">תאריך ושעת הזמנת משלוח: '.$cur_creation_date.'</p>';
                                    }
                                    ?>

                                    <?php if(current_user_can('administrator')){?>

                                    <input name="userid" type="hidden" value="<?php echo $userid;?>" />

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="ctcodes">Clinical Trial</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="ctcodes" class="form-control"  onchange="fetch_select('int_targets','int_targets','select',this.value);fetch_select('tests','tests','select',this.value);" <?php if($cur_tube_number){ echo ' disabled';}?>>
                                                <option value="-1" selected="">-- Choose Clinical Trial --</option>
                                                <?php 
                                                    $ct_codes = $wpdb->get_results( "SELECT * FROM aml_clinicaltrials");
                                                    foreach ( $ct_codes as $term ) {
                                                        
                                                        $selected = '';
                                                        if($term->ID == $cur_ctcodes){
                                                            $selected = ' selected';
                                                        }
                                                    ?>
                                                    <option value="<?php echo $term->ID;?>" <?php echo $selected; ?>><?php echo $term->name; ?></option>
                                                <?php 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="int_targets">Int Tagerts</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="int_targets" id="int_targets" class="form-control" required="">
                                                <option value="" selected="">-- Choose Int Target --</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="awb">AWB</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="awb" type="text" id="awb" value="<?php echo $cur_awb; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="shipment_number">Shipment Number</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="shipment_number" type="text" id="shipment_number" value="<?php echo $cur_shipment_number;?>" />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="outbound_shipment_date">Outbound Shipment Date </label>
                                        <div class="col-lg-4 col-sm-8">

                                            <input type="text" class="form-control" name="outbound_shipment_date" id="outbound_shipment_date" required  value="<?php echo $cur_outbound_shipment_date;?>">
                                        </div>
                                    </div>


                                    <div  class="form-group row"  id="shipment_hours">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">Pickup Hour</label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <span class="input-group-addon bg-custom b-0 text-white">From</span>
                                            <select class="form-control" name="hour_from" type="text" id="hour_from">
                                                <option value="8" <?php if($cur_hour_from == '8'){echo ' selected';}?>>08:00</option>
                                                <option value="9" <?php if($cur_hour_from == '9'){echo ' selected';}?>>09:00</option>
                                                <option value="10" <?php if($cur_hour_from == '10'){echo ' selected';}?>>10:00</option>
                                                <option value="11" <?php if($cur_hour_from == '11'){echo ' selected';}?>>11:00</option>
                                                <option value="12" <?php if($cur_hour_from == '12'){echo ' selected';}?>>12:00</option>
                                                <option value="13" <?php if($cur_hour_from == '13'){echo ' selected';}?>>13:00</option>
                                                <option value="14" <?php if($cur_hour_from == '14'){echo ' selected';}?>>14:00</option>
                                                <option value="15" <?php if($cur_hour_from == '15'){echo ' selected';}?>>15:00</option>
                                                <option value="16" <?php if($cur_hour_from == '16'){echo ' selected';}?>>16:00</option>
                                                <option value="17" <?php if($cur_hour_from == '17'){echo ' selected';}?>>17:00</option>
                                                <option value="18" <?php if($cur_hour_from == '18'){echo ' selected';}?>>18:00</option>
                                                <option value="19" <?php if($cur_hour_from == '19'){echo ' selected';}?>>19:00</option>

                                            </select>
                                            <span class="input-group-addon bg-custom b-0 text-white">To</span>
                                            <select class="form-control" name="hour_to" type="text" id="hour_to">
                                                <option value="8" <?php if($cur_hour_to == '8'){echo ' selected';}?>>08:00</option>
                                                <option value="9" <?php if($cur_hour_to == '9'){echo ' selected';}?>>09:00</option>
                                                <option value="10" <?php if($cur_hour_to == '10'){echo ' selected';}?>>10:00</option>
                                                <option value="11" <?php if($cur_hour_to == '11'){echo ' selected';}?>>11:00</option>
                                                <option value="12" <?php if($cur_hour_to == '12'){echo ' selected';}?>>12:00</option>
                                                <option value="13" <?php if($cur_hour_to == '13'){echo ' selected';}?>>13:00</option>
                                                <option value="14" <?php if($cur_hour_to == '14'){echo ' selected';}?>>14:00</option>
                                                <option value="15" <?php if($cur_hour_to == '15'){echo ' selected';}?>>15:00</option>
                                                <option value="16" <?php if($cur_hour_to == '16'){echo ' selected';}?>>16:00</option>
                                                <option value="17" <?php if($cur_hour_to == '17'){echo ' selected';}?>>17:00</option>
                                                <option value="18" <?php if($cur_hour_to == '18'){echo ' selected';}?>>18:00</option>

                                                <option value="19" <?php if($cur_hour_to == '19'){echo ' selected';}?>>19:00</option>
                                                <option value="20" <?php if($cur_hour_to == '20'){echo ' selected';}?>>20:00</option>

                                            </select>
                                        </div>
                                        
                                    </div> 

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="world_courier">Courier</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php $world_courier = $wpdb->get_results( "SELECT * FROM aml_world_couriers" ); ?>
                                            <select  name="world_courier" class="form-control" required="">
                                                <option value="" disabled="" selected="">-- Choose Courier --</option>
                                                <?php $count = count($world_courier); if ( $count > 0 ){ 
                                                    foreach ( $world_courier as $term ) {
                                                        $selected = '';
                                                        if($term->ID == $cur_world_courier){
                                                            $selected = ' selected';
                                                        }

                                                    ?>
                                                    <option value="<?php echo $term->ID;?>" <?php echo $selected; ?>><?php echo $term->name; ?></option>
                                                <?php } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="shipping_type">Shipping Type</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php $shipping_type = $wpdb->get_results( "SELECT * FROM aml_shipping_types" ); ?>
                                            <select  name="shipping_type" class="form-control" required="">
                                                <option value="" disabled="" selected="">-- Choose A Shipping Type --</option>
                                                <?php $count = count($shipping_type); if ( $count > 0 ){ 
                                                    foreach ( $shipping_type as $term ) {
                                                        $selected = '';
                                                        if($term->ID == $cur_shipping_type){
                                                            $selected = ' selected';
                                                        }

                                                    ?>
                                                    <option value="<?php echo $term->ID;?>" <?php echo $selected; ?>><?php echo $term->name; ?></option>
                                                <?php } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <?php
                                    //end if admin
                                    }
                                    ?>



                                    <?php if(current_user_can('contributor')){?>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="ctcodes">Clinical Trial</label>
                                        <div class="col-lg-4 col-sm-8">
                                            
                                                
                                                <?php 
                                                    $ct_codes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where id=".$cur_ctcodes);
                                                    
                                                    ?>
                                                    <?php echo $ct_codes->name; ?>
                                                
                                                
                                                
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="int_targets">Int Tagerts</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php 
                                                    $int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where id=".$cur_int_targets);
                                                    
                                                    ?>
                                                    <?php echo $int_targets->name; ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="awb">AWB</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_awb; ?>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="shipment_number">Shipment Number</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_shipment_number;?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="outbound_shipment_date">Outbound Shipment Date </label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_outbound_shipment_date;?>
                                        </div>
                                    </div>


                                    <div  class="form-group row"  id="shipment_hours">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">Pickup Hour</label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <span class="input-group-addon bg-custom b-0 text-white">From</span>
                                            <select class="form-control" name="hour_from" type="text" id="hour_from">
                                                <option value="8" <?php if($cur_hour_from == '8'){echo ' selected';}?>>08:00</option>
                                                <option value="9" <?php if($cur_hour_from == '9'){echo ' selected';}?>>09:00</option>
                                                <option value="10" <?php if($cur_hour_from == '10'){echo ' selected';}?>>10:00</option>
                                                <option value="11" <?php if($cur_hour_from == '11'){echo ' selected';}?>>11:00</option>
                                                <option value="12" <?php if($cur_hour_from == '12'){echo ' selected';}?>>12:00</option>
                                                <option value="13" <?php if($cur_hour_from == '13'){echo ' selected';}?>>13:00</option>
                                                <option value="14" <?php if($cur_hour_from == '14'){echo ' selected';}?>>14:00</option>
                                                <option value="15" <?php if($cur_hour_from == '15'){echo ' selected';}?>>15:00</option>
                                                <option value="16" <?php if($cur_hour_from == '16'){echo ' selected';}?>>16:00</option>
                                                <option value="17" <?php if($cur_hour_from == '17'){echo ' selected';}?>>17:00</option>
                                                <option value="18" <?php if($cur_hour_from == '18'){echo ' selected';}?>>18:00</option>
                                                <option value="19" <?php if($cur_hour_from == '19'){echo ' selected';}?>>19:00</option>

                                            </select>
                                            <span class="input-group-addon bg-custom b-0 text-white">To</span>
                                            <select class="form-control" name="hour_to" type="text" id="hour_to">
                                                <option value="8" <?php if($cur_hour_to == '8'){echo ' selected';}?>>08:00</option>
                                                <option value="9" <?php if($cur_hour_to == '9'){echo ' selected';}?>>09:00</option>
                                                <option value="10" <?php if($cur_hour_to == '10'){echo ' selected';}?>>10:00</option>
                                                <option value="11" <?php if($cur_hour_to == '11'){echo ' selected';}?>>11:00</option>
                                                <option value="12" <?php if($cur_hour_to == '12'){echo ' selected';}?>>12:00</option>
                                                <option value="13" <?php if($cur_hour_to == '13'){echo ' selected';}?>>13:00</option>
                                                <option value="14" <?php if($cur_hour_to == '14'){echo ' selected';}?>>14:00</option>
                                                <option value="15" <?php if($cur_hour_to == '15'){echo ' selected';}?>>15:00</option>
                                                <option value="16" <?php if($cur_hour_to == '16'){echo ' selected';}?>>16:00</option>
                                                <option value="17" <?php if($cur_hour_to == '17'){echo ' selected';}?>>17:00</option>
                                                <option value="18" <?php if($cur_hour_to == '18'){echo ' selected';}?>>18:00</option>

                                                <option value="19" <?php if($cur_hour_to == '19'){echo ' selected';}?>>19:00</option>
                                                <option value="20" <?php if($cur_hour_to == '20'){echo ' selected';}?>>20:00</option>

                                            </select>
                                        </div>
                                        
                                    </div> 

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="world_courier">Courier</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php 
                                                    $world_couriers = $wpdb->get_row( "SELECT * FROM aml_world_couriers where id=".$cur_world_courier);
                                                    
                                                    ?>
                                                    <?php echo $world_couriers->name; ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="shipping_type">Shipping Type</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php 
                                                    $shipping_types = $wpdb->get_row( "SELECT * FROM aml_shipping_types where id=".$cur_shipping_type);
                                                    
                                                    ?>
                                                    <?php echo $shipping_types->name; ?>
                                        </div>
                                    </div>


                                    <?php
                                    //end if contributer
                                    }
                                    ?>



                                    <?php if(current_user_can('administrator') || current_user_can('contributor')){?>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="status">סטטוס</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select class="form-control" name="status" onchange="change_status(this,'<?php echo $_GET['formid'];?>',this.value)">
                                                <option value="1" <?php if($cur_status == 1){echo ' selected';}?>>הוזמן</option>
                                                <option value="2" <?php if($cur_status == 2){echo ' selected';}?>>בוטל</option>
                                                <option value="3" <?php if($cur_status == 3){echo ' selected';}?>>התקבל</option>
                                                <option value="4" <?php if($cur_status == 4){echo ' selected';}?>>נשלח</option>
                                            </select>
                                            
                                        </div>
                                    </div> 

                                    <div id="tubes" class="col-lg-6 col-sm-6 col-form-label">
                                        <?php 
                                        $cnt_loop = 1;
                                        
                                        if ( $cur_tube_number ){ 
                                        $current_test_value;
                                        foreach ($cur_tube_number as $index => $value){
                                            $current_test_value[] = $cur_tests[$index];

                                            ?>
                                        <div class="section form-group row">
                                            <fieldset class="col-lg-12 col-sm-12 col-form-label">
                                                <div class="col-lg-6 col-xs-12 pull-left col-form-label">
                                                    <label class="col-form-label" for="tube_number">Accession Number</label>
                                                    <input class="form-control" name="tube_number[]" type="text" id="tube_number<?php echo $cnt_loop;?>" value="<?php echo $cur_tube_number[$index];?>" />
                                                 </div>
                                                 <div class="col-lg-6 col-xs-12 pull-left col-form-label">   
                                                    <label class="col-form-label" for="tests">Tube Name</label>
                                                    <select  name="tests[]" id="tests<?php echo $cnt_loop;?>" class="form-control">
                                                            <option value="" selected="">-- Choose Tube Names --</option>
                                                        </select>

                                                </div>
                                               


                                                <p><a href="#" class='remove'>Remove Accession</a></p>

                                            </fieldset>
                                        </div>
                                        <?php 
                                        $cnt_loop++;
                                            } 

                                        }else{ ?>
                                        <div class="section form-group row">
                                            <fieldset class="col-lg-12 col-sm-12 col-form-label">
                                                <div class="col-lg-6 col-xs-12 pull-left col-form-label">
                                                    <label class="col-form-label" for="tube_number">Accession Number</label>
                                                    <input class="form-control" name="tube_number[]" type="text" id="tube_number<?php echo $cnt_loop;?>" value="<?php echo $cur_tube_number[$index];?>" />
                                                 </div>
                                                 <div class="col-lg-6 col-xs-12 pull-left col-form-label">   
                                                    <label class="col-form-label" for="tests">Tube Name</label>
                                                    <select  name="tests[]" id="tests<?php echo $cnt_loop;?>" class="form-control">
                                                            <option value="" selected="">-- Choose Tube Names --</option>
                                                        </select>

                                                </div>
                                               


                                                <p><a href="#" class='remove'>Remove Accession</a></p>

                                            </fieldset>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <p><a href="#" class='addsection'>Add Accession</a></p>




                                    <div class="form-group row">
                                            
                                            <button name="action" type="submit" id="update-form" class="btn btn btn-default" value="update-form"><?php _e('Update', 'profile'); ?></button>

                                            <button name="action" type="submit" id="update-send-form" class="btn btn btn-default" value="update-send-form"><?php _e('Update & Send', 'profile'); ?></button>

                                            <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>

                                            <button id="manifest" type="button" class="btn btn-manifest" data-toggle="modal" data-target="#myModal">Create Manifest</button>
                                            
    
                                    </div><!-- .form-submit -->



                                    <?php
                                    //end if contributer
                                    }
                                    ?>







                                    </form><!-- #adduser -->
                                
                            </div><!-- .entry-content -->
                        </div><!-- .hentry .post -->

                            <?php endwhile; ?>

                        <?php endif; ?>
                            </div>
                        </div>
                        </div>



                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include('aml_footer_menu.php');?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            

        </div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Create Manifest</h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        
      </div>
      <div class="modal-body">
          <div class="form-group row">
            <label class="col-lg-4 col-sm-4 col-form-label" for="manifest_name">Enter Your Name</label>
            <div class="col-lg-8 col-sm-8">
                <input class="form-control" name="manifest_name" type="text" id="manifest_name" value="" />

            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="create_manifest_bt" type="button" class="btn btn-default">Create</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->        
        <!-- END wrapper -->
<?php get_footer();?>


<?php
function clean_str($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
?>

 <script>
var $form = $('form')
$( document ).ready(function() {
    
    $("#outbound_shipment_date").datepicker({
        <?php if(!current_user_can('administrator')){?> startDate: "today", <?php }?> 
        format: 'dd/mm/yyyy'
    });

    <?php if($current_test_value){
        //if there are already tubes
    ?>
    var tests_arr = [<?php echo '"'.implode('","',  $current_test_value ).'"' ?>];
    var cnt_loop = <?php echo $cnt_loop;?>;
    var i = 1;
    while (i < cnt_loop) {

        var cur_test_val = tests_arr[i-1];

        fetch_select('tests','tests'+i,'select',<?php echo $cur_ctcodes;?>,cur_test_val);

        i++;
    }
    <?php } else{?>
            //first edit or no tubes
        fetch_select('tests','tests1','select',<?php echo $cur_ctcodes;?>);
    <?php } ?>
    
    
         $('.modal').on('shown.bs.modal',function(){
          //$(this).find('iframe').attr('src','<?php //echo bloginfo('url');?>/fetch/aml_print_int_forms.php?formid=<?php //echo $_GET['formid'];?>')

        })
   


    fetch_select('int_targets','int_targets','select',<?php echo $cur_ctcodes;?>);
    
    //define template
    var template = $('#tubes .section:first').clone();

    //define counter
    var sectionsCount = 1;

    $('body').on('click', '.addsection', function() {

        //increment
        sectionsCount++;

        //loop through each input
        var section = template.clone().find(':input').each(function(){

            //set id to store the updated section number
            var newId = this.id + sectionsCount;

            //update for label
            $(this).prev().attr('for', newId);

            //update id
            this.id = newId;
            this.value = '';
            fetch_select('tests',this.id,'select',<?php echo $cur_ctcodes;?>);
            
            

        }).end()

        //inject new section
        .appendTo('#tubes');



        return false;
    });


    $('#tubes').on('click', '.remove', function() {
    //fade out section
    $(this).parent().fadeOut(300, function(){
        //remove parent element (main section)
        $(this).parent().parent().empty();
        return false;
    });
    return false;
});


//create manifest
$("#create_manifest_bt").click(function(){
var manifest_name = $("#manifest_name").val();
var cur_date = "<?php echo preg_replace('/[^0-9]/', '', $cur_outbound_shipment_date);?>";
var ctcode = "<?php echo clean_str($ct_code_name->name);?>";

if(manifest_name){
    $('#create_manifest_bt').prop("disabled",true);
    $('#create_manifest_bt').text("Loading...");


    $.ajax({
     type: 'post',
     url: '../fetch/aml_pdf_int_forms.php',
     
     data: {
      formid:<?php echo $_GET['formid'];?>,
      ctcode:ctcode,
      shipment_date:cur_date,
      manifest_name:manifest_name
     },
     success: function (response) {
        
        $('#create_manifest_bt').prop("disabled",true);
        $('#create_manifest_bt').text("Create");
        document.location.href = "int-forms";
     }

    });
}else{
    $("#manifest_name").focus();
    alert("Please Insert Manifest Name");
}


});




    $('#updateform').submit(function(){
        var hour_from = $('#hour_from').val();
        var hour_to = $('#hour_to').val();
        
        
        if ( Number(hour_to) <= Number(hour_from) ) { 
           alert("Please fix pickup hours");     
           return false;
        }

        var currentTime = moment().format("HH:mm");
        <?php global $current_user;
              get_currentuserinfo();
              
              
        ?>
        var currentUser = "<?php echo $current_user->display_name;?>";
        
        


        
            if($($form).serialize()!=$($form).data('serialize')){

                
                var formId = "<?php echo $_GET['formid']; ?>";
                
                var array1 = $($form).data('serialize').split('&');
                var array2 = $($form).serialize().split('&');
                var currentDifference = arr_diff(array1,array2);

                var currentPage = 'טופס חול מספר ' + formId;
                

               $.ajax({
                 type: 'post',
                 url: '<?php echo bloginfo('url');?>/fetch/aml_log_create.php',
                 
                 data: {
                  formid:formId,
                  currentTime:currentTime,
                  currentUser:currentUser,
                  currentDifference:currentDifference,
                  LogType:currentPage

                 }
                });
            }

        
    });



    
 }); 



function fetch_select(fetch,return_to,field_type,val,cur_test_val)
{

 $.ajax({
 type: 'post',
 url: '../fetch/aml_fetch_'+fetch+'.php',
 dataType :'json',
 data: {
  get_option:val
 },
 success: function (response) {


switch(field_type) {
    case 'text':
        document.getElementById(return_to).value=response; 
        break;
    case 'select':
        var values;
        if (return_to == 'int_targets'){
            values = <?php echo $cur_int_targets;?>
        }
        if (return_to == 'tests'){
            values = <?php echo $cur_int_targets;?>
        }
        var dropdownList=$("#" + return_to);
        dropdownList.empty();
        dropdownList.append("<option value=\"\">-- Please Choose --</option>");
        for (var index=0;index<response.length;index++)
            {
                if(cur_test_val){
                    values = cur_test_val;
                }
                var selected = '';
                if (response[index].id == values){
                    selected = ' selected';
                }
                var listOption="<option value=\"" + response[index].id + "\"";
                listOption+=" "+selected+" ";
                listOption+=">";
                listOption+=response[index].name + "</option>";
                dropdownList.append(listOption);
            }

}

            //retrieve first form for log
            $($form).data('serialize',$($form).serialize());

 }
 });
}



</script>    