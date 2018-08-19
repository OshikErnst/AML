<?php 
/**
 * Template Name: Add Form
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
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'send-form' ) {



    $post_name = 'Form Sent by ' . $_POST['username'] . ' on ' . date("F j, Y, g:i a"); 


    $my_post = array(
    'post_title' => $post_name,
    
    'post_content' => $post_name,
    'post_status' => 'publish',
    'post_category' => array( 1 ),
    'post_author'   => $_POST['userid']
    );
    $the_post_id = wp_insert_post( $my_post );

    //save creation date
    $dt = new DateTime('now', new DateTimezone('Asia/Jerusalem'));
    add_post_meta( $the_post_id, 'creation_date', $dt->format('j/n/Y, H:i'));

    $the_visits = serialize($_POST['visits']);

    add_post_meta( $the_post_id, 'ctcodes', $_POST['ctcodes'] );
    add_post_meta( $the_post_id, 'visits', $the_visits );
    add_post_meta( $the_post_id, 'sites', $_POST['sites'] );
    add_post_meta( $the_post_id, 'address', $_POST['address'] );
    add_post_meta( $the_post_id, 'department', $_POST['department'] );
    add_post_meta( $the_post_id, 'targets', $_POST['targets'] );

    add_post_meta( $the_post_id, 'contact', $_POST['contact'] );
    add_post_meta( $the_post_id, 'phone', $_POST['phone'] );
    add_post_meta( $the_post_id, 'pickup', $_POST['pickup'] );
    add_post_meta( $the_post_id, 'zone', $_POST['zone'] );
    add_post_meta( $the_post_id, 'courier', $_POST['courier'] );
    add_post_meta( $the_post_id, 'courier_email', $_POST['courier_email'] );

    add_post_meta( $the_post_id, 'taxi_hour', $_POST['taxi_hour'] );
    add_post_meta( $the_post_id, 'taxi_mins', $_POST['taxi_mins'] );
    

    if($_POST['hour_from']){
    add_post_meta( $the_post_id, 'hour_from', $_POST['hour_from'].':00' );
    add_post_meta( $the_post_id, 'hour_to', $_POST['hour_to'].':00' );
    }else{
    add_post_meta( $the_post_id, 'hour_from', $_POST['hour_from'] );
    add_post_meta( $the_post_id, 'hour_to', $_POST['hour_to'] );    
    }        


    add_post_meta( $the_post_id, 'date', $_POST['date'] );
    add_post_meta( $the_post_id, 'notes', $_POST['notes'] );

    add_post_meta( $the_post_id, 'status', 1 );

    $mail_zone = $wpdb->get_row( "SELECT * FROM aml_zones where ID = " . $_POST['zone']);

    $mail_courier = $wpdb->get_row( "SELECT * FROM aml_couriers where ID = " . $_POST['courier']);
    
    $mail_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $_POST['ctcodes']);
    $mail_sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $_POST['sites']);
    $mail_pickup = $wpdb->get_row( "SELECT * FROM aml_pickup_types where ID = " . $_POST['pickup']);
    $mail_target = $wpdb->get_row( "SELECT * FROM aml_targets where ID = " . $_POST['targets']);

    $mail_visits = $_POST['visits'];
    foreach ( $mail_visits as $term ) {
        $the_visits = $wpdb->get_row( "SELECT name FROM aml_visits where ID = " . $term);
        $cur_visit .= $the_visits->name . ' / ';


    }
    
    /* EMAIL */

    $content = 'נבקש לתאם את המשלוח הבא :<br /><br /><table cellpadding=10 cellspasing=10><tr><td>מחקר</td><td style="direction:rtl;text-align:center;">'.$mail_ct_code->name.'</td><td>Study name</td></tr><tr><td>בית חולים</td><td style="direction:rtl;text-align:center;">'.$mail_sites->name.' - '.$mail_sites->department.'</td><td>Hospital</td></tr><tr><td>מחלקה</td><td style="direction:rtl;text-align:center;">'.$_POST['department'].'</td><td>Department</td></tr><tr><td>אזור בארץ</td><td style="direction:rtl;text-align:center;">'.$mail_zone->name.'</td><td>zone</td></tr><tr><td>חברת הובלה</td><td style="direction:rtl;text-align:center;">'.$mail_courier->name.'</td><td>courier</td></tr><tr><td>איש קשר</td><td style="direction:rtl;text-align:center;">'.$_POST['contact'].'</td><td>Contact person</td></tr><tr><td>כתובת איסוף</td><td style="direction:rtl;text-align:center;">'.$_POST['address'].'</td><td>Pickup Address</td></tr><tr><td>טלפון</td><td style="text-align:center;">'.$_POST['phone'].'</td><td>Tel Number</td></tr><tr><td>סוג איסוף</td><td style="direction:rtl;text-align:center;">'.$mail_pickup->name.'</td><td>Kind of shipment</td></tr><tr><td>יעד המשלוח</td><td style="direction:rtl;text-align:center;">'.$mail_target->address.'</td><td>shipment target</td></tr><tr><td>תאריך איסוף</td><td style="text-align:center;">'.$_POST['date'].'</td><td>Inbound shipment(Date)</td></tr><tr><td>שעות איסוף</td><td style="text-align:center;">'.$_POST['hour_from'].'-'.$_POST['hour_to'].' / '.$_POST['taxi_hour'].':'.$_POST['taxi_mins'].'</td><td>Time of shipment</td></tr><tr><td>הערות</td><td style="direction:rtl;text-align:center;">'.$_POST['notes'].'</td><td>Comment</td></tr><tr><td>ביקור</td><td style="text-align:center;">'.$cur_visit.'</td><td>Visit</td></tr><tr><td>הוזמן על ידי</td><td style="text-align:center;">'.$_POST['username'].'</td><td>ordered by</td></tr><tr><td>מספר הזמנה</td><td style="text-align:center;">'.$the_post_id.'</td><td>Order Num</td></tr></table>';



    
        $pickup_type = array("7","13","14","15","16","17","18","20","21","22","23");
        if(in_array($_POST['pickup'],$pickup_type) ){
            $courier_email = $wpdb->get_row( "SELECT email FROM aml_couriers where ID = 6");
            $courier_email = $courier_email->email;
        }else{
            $courier_email = $_POST['courier_email'];
        }


    /*$current_user = wp_get_current_user();
    $cur_user_email = $current_user->user_email;*/

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

    //$mail->AddAddress("undisclosed-recipients:;");
    
    //clean and split to different emails
    trim($courier_email);
    $array = explode(',', $courier_email); //split string into array seperated by ', '
        foreach($array as $value) //loop over values
        {
            $mail->AddBCC($value, $value); 
        }
    
    //add current user email too
    /*if($cur_user_email){
    $mail->AddBCC($cur_user_email, $cur_user_email);          
    }*/


    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Delivery request from AML: " . $mail_ct_code->name ." - ". $mail_pickup->name ;
    $mail->Body    = $content;

    $mail->send();
    
    
    
    if(!current_user_can('administrator')){
        wp_redirect( get_bloginfo('url') . '/forms?sent=true' );
        exit();
    }else{
        wp_redirect( home_url().'/?sent=true' );
    }
    

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

                                <h4 class="page-title">Form</h4>
                                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <div id="post-<?php the_ID(); ?>" style="direction: rtl;">
                                    <div class="entry-content entry">

                                    <?php if ( $_GET['sent'] == 'true' ) : ?> <div id="message" class="text-success"><p>form sent</p></div> <?php endif; ?>

                                    <form method="post" id="newform" action="<?php the_permalink(); ?>" >

                                    <?php
                                    global $post; 
                                    $post = get_post( $_GET['formid'] );
                                    setup_postdata( $post );
                                    $cur_ctcodes = get_post_meta( get_the_ID(), 'ctcodes', true );
                                    $cur_visits = unserialize(get_post_meta(get_the_ID(),'visits',true));
                                    $cur_sites = get_post_meta( get_the_ID(), 'sites', true );
                                    $cur_targets = get_post_meta( get_the_ID(), 'targets', true );
                                    $cur_contact = get_post_meta( get_the_ID(), 'contact', true );
                                    $cur_contact_phone = get_post_meta( get_the_ID(), 'phone', true );

                                    $cur_pickup = get_post_meta( get_the_ID(), 'pickup', true );
                                    $cur_zone = get_post_meta( get_the_ID(), 'zone', true );
                                    $cur_courier = get_post_meta( get_the_ID(), 'courier', true );
                                    $cur_email = get_post_meta( get_the_ID(), 'courier_email', true );

                                    $cur_taxi_hour = get_post_meta( get_the_ID(), 'taxi_hour', true );
                                    $cur_taxi_mins = get_post_meta( get_the_ID(), 'taxi_mins', true );
                                    $cur_hour_from = get_post_meta( get_the_ID(), 'hour_from', true );
                                    $cur_hour_to = get_post_meta( get_the_ID(), 'hour_to', true );

                                    $cur_date = get_post_meta( get_the_ID(), 'date', true );
                                    $cur_notes = get_post_meta( get_the_ID(), 'notes', true );

                                    ?>
                    



                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="username">שם שולח</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="username" type="hidden" id="username" value="<?php the_author_meta( 'display_name', $user_info->ID ); ?>" />
                                            <input type="hidden" name="userid" value="<?php echo $user_info->ID;?>" />
                                            <p><?php echo $user_info->display_name;?></p>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="ctcodes">מחקר קליני</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php $current_arr = get_the_author_meta( 'ctcodes', $user_info->ID ); ?>
                                            <select  name="ctcodes" onchange="fetch_select('visits','visits','select',this.value);" class="form-control" required="">
                                                <option value="" disabled="" selected="">-- Choose Clinical Trial --</option>
                                                <?php $count = count($current_arr); if ( $count > 0 ){ 
                                                    foreach ( $current_arr as $term ) {
                                                        $ct_codes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $term);

                                                    ?>
                                                    <option value="<?php echo $ct_codes->ID;?>"><?php echo $ct_codes->name; ?></option>
                                                <?php } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="visits">ביקור</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="visits[]" id="visits" multiple="multiple" class="form-control select2 select2-multiple" required="" data-placeholder="Choose ...">
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <hr />

                                    <h4>משלוח מ:</h4>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="sites">שם אתר</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php $current_arr = get_the_author_meta( 'sites', $user_info->ID );

                                            $sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $current_arr); ?>
                                            <input type="hidden" class="form-control" value="<?php echo $sites->ID;?>" name="sites" id="sites" />
                                                <?php 

                                                echo $sites->name; ?> - <?php 

                                                echo $sites->department; ?>
                                        </div>
                                    </div>

                                    <?php 
                                        $current_arr = get_the_author_meta( 'sites', $user_info->ID ); 
                                        $sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $current_arr);
                                    ?>



                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="address">כתובת</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input type="hidden" value="<?php echo $sites->address;?>" name="address" id="address" />
                                            <?php echo $sites->address;?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="department">מחלקה</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input type="hidden" value="<?php echo $sites->department;?>" name="department" id="address" />
                                            <?php echo $sites->department;?>
                                        </div>
                                    </div>

                                    <h4>משלוח אל:</h4> 

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="targets">יעד</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php $targets = $wpdb->get_results( "SELECT * FROM aml_targets"); ?>
                                            <select  name="targets" class="form-control" required="">
                                                <option value="" selected="">-- Choose Target --</option>
                                                <?php $count = count($targets); if ( $count > 0 ){ 
                                                    foreach ( $targets as $term ) {?>
                                                    <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?>-<?php echo $term->address; ?></option>
                                                <?php } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <hr />

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="contact">איש קשר</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="contact" type="text" id="contact" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="phone">איש קשר - טלפון</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="phone" type="text" id="phone" value="" />
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="pickup">סוגי שליחות</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php 
                                             $pickups = $wpdb->get_results( "SELECT * FROM aml_pickup_types");
                                            ?>
                                            
                                            <select id="pickup" name="pickup" onchange="check_pickuptype();" class="form-control" required="">
                                                <option value="" selected="">-- Choose Pickup Type --</option>
                                                <?php $count = count($pickups); if ( $count > 0 ){ 
                                                    foreach ( $pickups as $term ) {?>
                                                    <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
                                                <?php } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php $zones = $wpdb->get_row( "SELECT * FROM aml_zones where ID = " . $sites->zone);?>



                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="zone">אזור בארץ</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="zone" type="hidden" id="zone" value="<?php echo $zones->ID;?>" />
                                            <?php echo $zones->name;?>
                                        </div>
                                    </div>



                                    <div class="form-group row">

                                        <?php 
                                        $couriers = $wpdb->get_row( "SELECT * FROM aml_couriers_zones WHERE zone_id=" .$zones->ID );
                                            
                                        

                                         $courier_name = $wpdb->get_row( "SELECT * FROM aml_couriers WHERE ID=" .$couriers->courier_id );  

                                        ?>
                                        <input class="form-control" name="courier_id_first" type="hidden" id="courier_id_first" value="<?php echo $courier_name->ID;?>" />
                                        <input class="form-control" name="courier_email_first" type="hidden" id="courier_email_first" value="<?php echo $courier_name->email;?>" />
                                        <input class="form-control" name="courier_name_first" type="hidden" id="courier_name_first" value="<?php echo $courier_name->name;?>" />

                                        
                                        <input class="form-control" name="courier" type="hidden" id="courier" value="<?php echo $courier_name->ID;?>" />
                                        <input class="form-control" name="courier_email" type="hidden" id="courier_email" value="<?php echo $courier_name->email;?>" />
                                        <?php if(current_user_can('administrator')){?>
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="courier">חברת שליחויות
                                            </label>
                                        <div class="col-lg-4 col-sm-8">
                                            
                                            <div class="courier_text"><?php echo $courier_name->name;?></div>
                                            <small>*חברת שליחויות לפי אזור בארץ</small>
                                             <br /><small>* אם נבחר קרח אז בכל מקרה יהיה במהירות הכל.</small>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="date">תאריך איסוף</label>
                                        <div class="col-lg-4 col-sm-8">

                                            <input type="text" class="form-control" required value="<?php echo date("d/m/Y"); ?>" name="date" id="date">
                                        </div>
                                    </div>


                                    <div class="form-group row" id="taxi_pickup" style="display: none;">
                                        
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">שעת איסוף -מונית</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <div class="form-group row col-12">
                                                <div class="col-4 col-lg-4 col-sm-4 center-block input-group-addon bg-custom b-0 text-white">דקות</div>
                                                <div class="col-2"></div>
                                                <div class="col-4 col-lg-4 col-sm-4 center-block input-group-addon bg-custom b-0 text-white">שעות</div>
                                            </div>
                                            <div class="form-group row col-12">
                                                <select class="col-4 form-control col-lg-4 col-sm-4" name="taxi_mins" type="text" id="taxi_mins">
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30" selected="">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                                <div class="col-2"></div>
                                                <select class="col-4 form-control col-lg-4 col-sm-4" name="taxi_hour" type="text" id="taxi_hour">
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10" selected="">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>

                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="00">00</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="form-group row"  id="notaxi_pickup">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">שעת איסוף</label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <span class="input-group-addon bg-custom b-0 text-white">משעה</span>
                                            <select class="form-control" name="hour_from" type="text" id="hour_from" onchange="check_hour_dif(this.value,this.id);">
                                                <option value="8">08:00</option>
                                                <option value="9">09:00</option>
                                                <option value="10">10:00</option>
                                                <option value="11">11:00</option>
                                                <option value="12">12:00</option>
                                                <option value="13">13:00</option>
                                                <option value="14">14:00</option>
                                                <option value="15">15:00</option>
                                                <option value="16">16:00</option>
                                                <option value="17">17:00</option>
                                                <option value="18">18:00</option>

                                                <option value="19">19:00</option>
                                                <option value="20">20:00</option>
                                                <option value="21">21:00</option>
                                                <option value="22">22:00</option>
                                                <option value="23">23:00</option>
                                                <option value="24">00:00</option>
                                            </select>
                                            <span class="input-group-addon bg-custom b-0 text-white">עד</span>
                                            <select class="form-control" name="hour_to" type="text" id="hour_to" onchange="check_hour_dif(this.value,this.id);">
                                                <option value="8">08:00</option>
                                                <option value="9">09:00</option>
                                                <option value="10" selected="">10:00</option>
                                                <option value="11">11:00</option>
                                                <option value="12">12:00</option>
                                                <option value="13">13:00</option>
                                                <option value="14">14:00</option>
                                                <option value="15">15:00</option>
                                                <option value="16">16:00</option>
                                                <option value="17">17:00</option>
                                                <option value="18">18:00</option>

                                                <option value="19">19:00</option>
                                                <option value="20">20:00</option>
                                                <option value="21">21:00</option>
                                                <option value="22">22:00</option>
                                                <option value="23">23:00</option>
                                                <option value="24">00:00</option>
                                            </select>
                                        </div>
                                        
                                    </div> 


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="notes">הערות</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <textarea class="form-control" name="notes" id="notes"></textarea>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                            <?php echo $referer; ?>
                                            <div class="sending">שולח...</div>
                                            <button name="send-form" type="submit" id="send-form" class="btn btn-default"><?php _e('שלח', 'profile'); ?></button>

                                            <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('בטל', 'profile'); ?></button>
                                            
                                            <input name="action" type="hidden" id="action" value="send-form" />
    
                                    </div><!-- .form-submit -->

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
        <!-- END wrapper -->


<!-- cant_send modal-->
<div class="modal fade" id="cant_send" tabindex="-1" role="dialog" aria-labelledby="cant_send" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h3 class="text-center text-danger" style="width:100%;">שימו לב</h3>
      </div>
      

      <div class="modal-body text-center" style="direction: rtl;">
          שלום רב, <br />
            בשעה זו לא ניתן לתאם משלוח. אנא צרו קשר עם צוות מחלקת המחקרים <br />
            בטלפון  09-9561268 או באימייל  <a href="mailto:amlcustserv@aml.co.il">amlcustserv@aml.co.il</a>
        </div>
        
      </div>
      
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->  

<?php get_footer();?>

 <script>
    var hour_limit;
$( document ).ready(function() {
    $("#date").datepicker({
        <?php if(!current_user_can('administrator')){?> startDate: "today", <?php }?> 
        format: 'dd/mm/yyyy'
    });
    
    $('#cancel-form').click(function() {
        if (confirm('Are you sure?')) {
          window.location.href = "<?php echo bloginfo('url');?>/forms";
        }
    });


    $('#newform').submit(function() {

        var todayObj = moment().format('DD/MM/YYYY');
        var dateString = $('#date').val();

        var todayLimit = dateString + " "  + hour_limit + ":00";
        todayLimit = moment(todayLimit, 'DD-MM-YYYY HH:mm');


        var nowObj = moment();


        //check if today passed then check if for future
     
        if(todayObj == dateString){
            
            if(nowObj >= todayLimit){
                
                $('#cant_send').modal('show');    
                return false;
            }
        }else{
            
            if(nowObj >= todayLimit){
                
                $('#cant_send').modal('show');    
                return false;
            }
        }
        
        $('.sending').show();
        
        
    });

    



    <?php if($sites->ID){?>
    $.ajax({
         type: 'post',
         url: '../fetch/aml_check_time_limit.php',
         data: {
          get_option:<?php echo $sites->ID;?>
         },
         success: function (response) {
            
            hour_limit = response.replace(':00', '');
            
            //select all wher value is more than hour_limit;
            
            $( "#hour_to option" ).each(function( index ) {
                if(Number($( this ).val()) > Number(hour_limit)){
                    $("#hour_to option[value="+$( this ).val()+"]").remove();
                    $("#hour_from option[value="+$( this ).val()+"]").remove();

                }
              
            });
            
         }
    });
    <?php } ?>

 }); 


function check_hour_dif(val,id){

    if(id=='hour_to'){
        var cur_hour = val-3;
        
        $("#hour_from option:selected").removeAttr("selected");
        $("#hour_from option[value="+cur_hour+"]").attr('selected', 'selected');
    }

    if(id=='hour_from'){
        var cur_hour = Number(val)+3;


        if(cur_hour >= hour_limit){
            $("#hour_to option[value="+hour_limit+"]").attr('selected', 'selected');

        }else{
            $("#hour_to option[value="+cur_hour+"]").attr('selected', 'selected');

        }

    }
    
}

function fetch_select(fetch,return_to,field_type,val)
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
        
        var dropdownList=$("#" + return_to);
        dropdownList.empty();
        //dropdownList.append("<option value=\"-1\" disabled=\"\" selected=\"\">-- Choose Clinical Trial --</option>");
        for (var index=0;index<response.length;index++)
            {
                var listOption="<option value=\"" + response[index].ID;
                listOption+="\">";
                listOption+=response[index].name + "</option>";
                dropdownList.append(listOption);
            }

}



 }
 });
}


function check_pickuptype(){
    //var selected = $("#pickup option:selected").text();
    var selected = $("#pickup option:selected").val();
    var ice_array = ["7","13","14","15","16","17","18","20","21","22","23"];
    //if (selected.indexOf("קרח") >= 0){
        console.log(selected);
    //if (selected.indexOf(ice_array)){
    if (ice_array.indexOf(selected) !== -1){

        $('#courier').attr('value','6');
        $('.courier_text').text('במהירות הכל');

        $.ajax({
         type: 'post',
         url: '../fetch/aml_fetch_emails.php',
         data: {
          get_option:6
         },
         success: function (response) {
            $('#courier_email').attr('value',response);
        }
        });


        
    }else{
        
        $('#courier').attr('value',$('#courier_id_first').attr('value'));
        $('.courier_text').text($('#courier_name_first').attr('value'));
        $('#courier_email').attr('value',$('#courier_email_first').attr('value'));

    }


 $.ajax({
 type: 'post',
 url: '../fetch/aml_fetch_is_taxi.php',
 data: {
  get_option:$("#pickup").val()
 },
 success: function (response) {
    if(response==0){
        
        $('#notaxi_pickup').show();
        $('#taxi_pickup').hide();
        $('#taxi_hour').attr("disabled","disabled");
        $('#taxi_mins').attr("disabled","disabled");
        $('#hour_from').removeAttr("disabled");
        $('#hour_to').removeAttr("disabled");

    }else{

        $('#notaxi_pickup').hide();
        $('#taxi_pickup').show();
        $('#taxi_hour').removeAttr("disabled");
        $('#taxi_mins').removeAttr("disabled");
        $('#hour_from').attr("disabled","disabled");
        $('#hour_to').attr("disabled","disabled");
    }
 }
 });

 



}

</script>    
