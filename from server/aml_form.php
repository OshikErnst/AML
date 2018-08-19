<?php 
/**
 * Template Name: Form page
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
    
    $arg = array('ID' => $the_post_id,'post_author' => $_POST['username'],);
    wp_update_post( $arg );

    
    $the_visits = serialize($_POST['visits']);

    update_post_meta( $the_post_id, 'ctcodes', $_POST['ctcodes'] );
    update_post_meta( $the_post_id, 'visits', $the_visits );
    update_post_meta( $the_post_id, 'sites', $_POST['sites'] );
    update_post_meta( $the_post_id, 'address', $_POST['address'] );
    update_post_meta( $the_post_id, 'department', $_POST['department'] );
    update_post_meta( $the_post_id, 'targets', $_POST['targets'] );

    update_post_meta( $the_post_id, 'contact', $_POST['contact'] );
    update_post_meta( $the_post_id, 'phone', $_POST['phone'] );
    update_post_meta( $the_post_id, 'pickup', $_POST['pickup'] );
    update_post_meta( $the_post_id, 'zone', $_POST['zone'] );
    update_post_meta( $the_post_id, 'courier', $_POST['courier'] );
    update_post_meta( $the_post_id, 'courier_email', $_POST['courier_email'] );


    update_post_meta( $the_post_id, 'taxi_hour', $_POST['taxi_hour'] );
    update_post_meta( $the_post_id, 'taxi_mins', $_POST['taxi_mins'] );
    
    if($_POST['hour_from']){
    update_post_meta( $the_post_id, 'hour_from', $_POST['hour_from'].':00' );
    update_post_meta( $the_post_id, 'hour_to', $_POST['hour_to'].':00' );
    }else{
    update_post_meta( $the_post_id, 'hour_from', $_POST['hour_from'] );
    update_post_meta( $the_post_id, 'hour_to', $_POST['hour_to'] );
    }

    update_post_meta( $the_post_id, 'date', $_POST['date'] );
    update_post_meta( $the_post_id, 'notes', $_POST['notes'] );
    update_post_meta( $the_post_id, 'status', $_POST['status'] );
    
    if($_POST['action'] == 'update-send-form'){
        $mail_zone = $wpdb->get_row( "SELECT * FROM aml_zones where ID = " . $_POST['zone']);

        $mail_courier = $wpdb->get_row( "SELECT * FROM aml_couriers where ID = " . $_POST['courier']);

        $mail_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $_POST['ctcodes']);
        $mail_sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $_POST['sites']);
        $mail_pickup = $wpdb->get_row( "SELECT * FROM aml_pickup_types where ID = " . $_POST['pickup']);
        $mail_target = $wpdb->get_row( "SELECT * FROM aml_targets where ID = " . $_POST['targets']);

        $user_info = get_userdata($_POST['username']);
        $mail_username = $user_info->display_name;
                    
        $mail_visits = $_POST['visits'];
        foreach ( $mail_visits as $term ) {
            $the_visits = $wpdb->get_row( "SELECT name FROM aml_visits where ID = " . $term);
            $cur_visit .= $the_visits->name . ' / ';


        }
        

        /* EMAIL */

        $content = 'נבקש לתאם את המשלוח הבא :<br /><br /><table cellpadding=10 cellspasing=10><tr><td>מחקר</td><td style="direction:rtl;text-align:center;">'.$mail_ct_code->name.'</td><td>Study name</td></tr><tr><td>בית חולים</td><td style="direction:rtl;text-align:center;">'.$mail_sites->name.' - '.$mail_sites->department.'</td><td>Hospital</td></tr><tr><td>מחלקה</td><td style="direction:rtl;text-align:center;">'.$_POST['department'].'</td><td>Department</td></tr><tr><td>אזור בארץ</td><td style="direction:rtl;text-align:center;">'.$mail_zone->name.'</td><td>zone</td></tr><tr><td>חברת הובלה</td><td style="direction:rtl;text-align:center;">'.$mail_courier->name.'</td><td>courier</td></tr><tr><td>איש קשר</td><td style="direction:rtl;text-align:center;">'.$_POST['contact'].'</td><td>Contact person</td></tr><tr><td>כתובת איסוף</td><td style="direction:rtl;text-align:center;">'.$_POST['address'].'</td><td>Pickup Address</td></tr><tr><td>טלפון</td><td style="text-align:center;">'.$_POST['phone'].'</td><td>Tel Number</td></tr><tr><td>סוג איסוף</td><td style="direction:rtl;text-align:center;">'.$mail_pickup->name.'</td><td>Kind of shipment</td></tr><tr><td>יעד המשלוח</td><td style="direction:rtl;text-align:center;">'.$mail_target->address.'</td><td>shipment target</td></tr><tr><td>תאריך איסוף</td><td style="text-align:center;">'.$_POST['date'].'</td><td>Inbound shipment(Date)</td></tr><tr><td>שעות איסוף</td><td style="text-align:center;">'.$_POST['hour_from'].'-'.$_POST['hour_to'].' / '.$_POST['taxi_hour'].':'.$_POST['taxi_mins'].'</td><td>Time of shipment</td></tr><tr><td>הערות</td><td style="direction:rtl;text-align:center;">'.$_POST['notes'].'</td><td>Comment</td></tr><tr><td>ביקור</td><td style="direction:rtl;text-align:center;">'.$cur_visit.'</td><td>Visit</td></tr><tr><td>הוזמן על ידי</td><td style="direction:rtl;text-align:center;">'.$mail_username.'</td><td>ordered by</td></tr><tr><td>מספר הזמנה</td><td style="text-align:center;">'.$the_post_id.'</td><td>Order Num</td></tr></table>';

          $courier_email = $_POST['courier_email'];


    
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

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "עדכון להזמנת שליחות : " . $mail_ct_code->name ." - ". $mail_pickup->name ;
    $mail->Body    = $content;

    $mail->send();


    }

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

                                <h4 class="page-title">Form</h4>
                                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <div id="post-<?php the_ID(); ?>" style="direction: rtl;">
                                    <div class="entry-content entry">
                                    <?php if ( $_GET['sent'] == 'true' ) : ?> <div id="message" class="text-success"><p>form updated</p></div> <?php endif; ?>

                                    <form method="post" id="updateform" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >

                                    <?php
                                    global $post; 
                                    $post = get_post( $_GET['formid'] );
                                    setup_postdata( $post );

                                    $cur_creation_date = get_post_meta( get_the_ID(), 'creation_date', true );

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
                                    $cur_status = get_post_meta( get_the_ID(), 'status', true );

                                    ?>

                                    <?php
                                    if($cur_creation_date){
                                        echo '<p style="font-size:18px;margin-bottom:20px;">תאריך ושעת הזמנת משלוח: '.$cur_creation_date.'</p>';
                                    }
                                    ?>
                    

                                    <?php if(current_user_can('administrator')){ ?>
                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="username">שם שולח</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select name="username" id="username" class="form-control">
                                                <option value="-1" selected="">-- Choose User --</option>
                                                <?php $blogusers = get_users( 'blog_id=1&orderby=nicename' );
                                                foreach ( $blogusers as $user ) {
                                                    $selected = '';
                                                    if($user->ID == get_the_author_meta('ID') ){
                                                        $selected = ' selected';
                                                    }
                                                echo '<option value='. $user->ID.' '.$selected.'>' . $user->display_name . '</option>';
                                                 

                                                }  ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="ctcodes">מחקר קליני</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="ctcodes" onchange="fetch_select('visits','visits','select',this.value);"  class="form-control">
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
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="visits">ביקור</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="visits[]" id="visits" multiple="multiple" class="form-control select2 select2-multiple" data-placeholder="Choose ..."  data-placeholder="Choose ...">
                                                
                                            </select>
                                        </div>
                                    </div>



                                    <hr />

                                    <h4>משלוח מ:</h4>    


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="sites">שם אתר</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="sites" class="form-control" required="">
                                                <option value="" selected="">-- Choose A Site --</option>
                                                <?php 
                                                    $sites = $wpdb->get_results( "SELECT * FROM aml_sites");

                                                    foreach ( $sites as $term ) {
                                                        
                                                        $selected = '';
                                                        if($term->ID == $cur_sites){
                                                            $selected = ' selected';
                                                        }
                                                    ?>
                                                    <option value="<?php echo $term->ID;?>" <?php echo $selected; ?>><?php echo $term->name; ?> - <?php echo $term->department; ?></option>
                                                <?php 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>                

                                    <?php 

                                        $sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $cur_sites);
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
                                            <input class="text-input" name="department" type="hidden" id="department" value="<?php echo $sites->department;?>" />
                                            <?php echo $sites->department;?>
                                        </div>
                                    </div>  

                                    <h4>משלוח אל:</h4>  

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="targets">יעד</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="targets" class="form-control">
                                                <option value="-1" selected="">-- Choose A Target --</option>
                                                <?php 
                                                    $targets = $wpdb->get_results( "SELECT * FROM aml_targets");

                                                    foreach ( $targets as $term ) {
                                                        
                                                        $selected = '';
                                                        if($term->ID == $cur_targets){
                                                            $selected = ' selected';
                                                        }
                                                    ?>
                                                    <option value="<?php echo $term->ID;?>" <?php echo $selected; ?>><?php echo $term->name; ?>-<?php echo $term->address; ?></option>
                                                <?php 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>  

                                    <hr />


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="contact">איש קשר</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="contact" type="text" id="contact" value="<?php echo $cur_contact; ?>" />
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="phone">איש קשר - טלפון</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="phone" type="text" id="phone" value="<?php echo $cur_contact_phone; ?>" />
                                        </div>
                                    </div>  


                                    <hr />


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="pickup">סוגי שליחות</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select id="pickup" name="pickup" onchange="check_pickuptype();" class="form-control">
                                                <option value="" selected="" disabled="">-- Choose Pickup Type --</option>
                                                <?php 
                                                    $pickups = $wpdb->get_results( "SELECT * FROM aml_pickup_types");

                                                    foreach ( $pickups as $term ) {
                                                        
                                                        $selected = '';
                                                        if($term->ID == $cur_pickup){
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
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="zone">אזור בארץ</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select  name="zone" class="form-control">
                                                <option value="-1" selected="">-- Choose A Zone --</option>
                                                <?php 
                                                    $zones = $wpdb->get_results( "SELECT * FROM aml_zones");

                                                    foreach ( $zones as $term ) {
                                                        
                                                        $selected = '';
                                                        if($term->ID == $cur_zone){
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
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="courier">חברת שליחויות<br /><small>*חברת שליחויות לפי אזור בארץ </small></label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <select  name="courier" id="courier" class="form-control" onchange="check_courier();">
                                                <option value="-1">-- Choose A Courier --</option>
                                                <?php 
                                                    $couriers = $wpdb->get_results( "SELECT * FROM aml_couriers");

                                                    foreach ( $couriers as $term ) {
                                                        
                                                        $selected = '';
                                                        if($term->ID == $cur_courier){
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
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="courier_email">
                                            חברת שליחויות - Email
                                        </label>
                                        <input class="form-control" name="courier_email" type="hidden" id="courier_email" value="<?php echo $cur_email;?>" />
                                        <div class="col-lg-4 col-sm-8 input-group" id="courier_email_text">
                                            
                                            <?php echo $cur_email;?>
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="date">תאריך איסוף</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input type="text" class="form-control" required value="<?php echo $cur_date;?>" name="date" id="date">
                                        </div>
                                    </div> 


                                    <div class="form-group row" id="taxi_pickup" style="display: none;">
                                        
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">שעת איסוף - מונית</label>


                                        <div class="col-lg-4 col-sm-8">
                                            <div class="form-group row col-12">
                                                <div class="col-4 col-lg-4 col-sm-4 center-block input-group-addon bg-custom b-0 text-white">דקות</div>
                                                <div class="col-2"></div>
                                                <div class="col-4 col-lg-4 col-sm-4 center-block input-group-addon bg-custom b-0 text-white">שעות</div>
                                            </div>
                                            <div class="form-group row col-12">
                                                <select class="col-4 form-control col-lg-4 col-sm-4" name="taxi_mins" type="text" id="taxi_mins">
                                                    <option value="00" <?php if($cur_taxi_mins == '00'){echo ' selected';}?>>00</option>
                                                    <option value="15" <?php if($cur_taxi_mins == '15'){echo ' selected';}?>>15</option>
                                                    <option value="30" <?php if($cur_taxi_mins == '30'){echo ' selected';}?>>30</option>
                                                    <option value="45" <?php if($cur_taxi_mins == '45'){echo ' selected';}?>>45</option>
                                                </select>
                                                <div class="col-2"></div>
                                                <select class="col-4 form-control col-lg-4 col-sm-4" name="taxi_hour" type="text" id="taxi_hour">
                                                    <option value="08" <?php if($cur_taxi_hour == '08'){echo ' selected';}?>>08</option>
                                                    <option value="09" <?php if($cur_taxi_hour == '09'){echo ' selected';}?>>09</option>
                                                    <option value="10" <?php if($cur_taxi_hour == '10'){echo ' selected';}?>>10</option>
                                                    <option value="11" <?php if($cur_taxi_hour == '11'){echo ' selected';}?>>11</option>
                                                    <option value="12" <?php if($cur_taxi_hour == '12'){echo ' selected';}?>>12</option>
                                                    <option value="13" <?php if($cur_taxi_hour == '13'){echo ' selected';}?>>13</option>
                                                    <option value="14" <?php if($cur_taxi_hour == '14'){echo ' selected';}?>>14</option>
                                                    <option value="15" <?php if($cur_taxi_hour == '15'){echo ' selected';}?>>15</option>
                                                    <option value="16" <?php if($cur_taxi_hour == '16'){echo ' selected';}?>>16</option>
                                                    <option value="17" <?php if($cur_taxi_hour == '17'){echo ' selected';}?>>17</option>
                                                    <option value="18" <?php if($cur_taxi_hour == '18'){echo ' selected';}?>>18</option>

                                                    <option value="19" <?php if($cur_taxi_hour == '19'){echo ' selected';}?>>19</option>
                                                    <option value="20" <?php if($cur_taxi_hour == '20'){echo ' selected';}?>>20</option>
                                                    <option value="21" <?php if($cur_taxi_hour == '21'){echo ' selected';}?>>21</option>
                                                    <option value="22" <?php if($cur_taxi_hour == '22'){echo ' selected';}?>>22</option>
                                                    <option value="23" <?php if($cur_taxi_hour == '23'){echo ' selected';}?>>23</option>
                                                    <option value="00" <?php if($cur_taxi_hour == '00'){echo ' selected';}?>>00</option>
                                                </select>
                                                
                                            </div>
                                        </div>


                                            
                                        </div>
                                    </div>

                                    <div  class="form-group row"  id="notaxi_pickup">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">שעת איסוף</label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <span class="input-group-addon bg-custom b-0 text-white">משעה</span>
                                            <select class="form-control" name="hour_from" type="text" id="hour_from" onchange="check_hour_dif(this.value,this.id);">
                                                <option value="8" <?php if($cur_hour_from == '8:00'){echo ' selected';}?>>08:00</option>
                                                <option value="9" <?php if($cur_hour_from == '9:00'){echo ' selected';}?>>09:00</option>
                                                <option value="10" <?php if($cur_hour_from == '10:00'){echo ' selected';}?>>10:00</option>
                                                <option value="11" <?php if($cur_hour_from == '11:00'){echo ' selected';}?>>11:00</option>
                                                <option value="12" <?php if($cur_hour_from == '12:00'){echo ' selected';}?>>12:00</option>
                                                <option value="13" <?php if($cur_hour_from == '13:00'){echo ' selected';}?>>13:00</option>
                                                <option value="14" <?php if($cur_hour_from == '14:00'){echo ' selected';}?>>14:00</option>
                                                <option value="15" <?php if($cur_hour_from == '15:00'){echo ' selected';}?>>15:00</option>
                                                <option value="16" <?php if($cur_hour_from == '16:00'){echo ' selected';}?>>16:00</option>
                                                <option value="17" <?php if($cur_hour_from == '17:00'){echo ' selected';}?>>17:00</option>
                                                <option value="18" <?php if($cur_hour_from == '18:00'){echo ' selected';}?>>18:00</option>

                                                <option value="19" <?php if($cur_hour_from == '19:00'){echo ' selected';}?>>19:00</option>
                                                <option value="20" <?php if($cur_hour_from == '20:00'){echo ' selected';}?>>20:00</option>
                                                <option value="21" <?php if($cur_hour_from == '21:00'){echo ' selected';}?>>21:00</option>
                                                <option value="22" <?php if($cur_hour_from == '22:00'){echo ' selected';}?>>22:00</option>
                                                <option value="23" <?php if($cur_hour_from == '23:00'){echo ' selected';}?>>23:00</option>
                                                <option value="24" <?php if($cur_hour_from == '24:00'){echo ' selected';}?>>00:00</option>
                                            </select>
                                            <span class="input-group-addon bg-custom b-0 text-white">עד</span>
                                            <select class="form-control" name="hour_to" type="text" id="hour_to" onchange="check_hour_dif(this.value,this.id);">
                                                <option value="8" <?php if($cur_hour_to == '8:00'){echo ' selected';}?>>08:00</option>
                                                <option value="9" <?php if($cur_hour_to == '9:00'){echo ' selected';}?>>09:00</option>
                                                <option value="10" <?php if($cur_hour_to == '10:00'){echo ' selected';}?>>10:00</option>
                                                <option value="11" <?php if($cur_hour_to == '11:00'){echo ' selected';}?>>11:00</option>
                                                <option value="12" <?php if($cur_hour_to == '12:00'){echo ' selected';}?>>12:00</option>
                                                <option value="13" <?php if($cur_hour_to == '13:00'){echo ' selected';}?>>13:00</option>
                                                <option value="14" <?php if($cur_hour_to == '14:00'){echo ' selected';}?>>14:00</option>
                                                <option value="15" <?php if($cur_hour_to == '15:00'){echo ' selected';}?>>15:00</option>
                                                <option value="16" <?php if($cur_hour_to == '16:00'){echo ' selected';}?>>16:00</option>
                                                <option value="17" <?php if($cur_hour_to == '17:00'){echo ' selected';}?>>17:00</option>
                                                <option value="18" <?php if($cur_hour_to == '18:00'){echo ' selected';}?>>18:00</option>

                                                <option value="19" <?php if($cur_hour_to == '19:00'){echo ' selected';}?>>19:00</option>
                                                <option value="20" <?php if($cur_hour_to == '20:00'){echo ' selected';}?>>20:00</option>
                                                <option value="21" <?php if($cur_hour_to == '21:00'){echo ' selected';}?>>21:00</option>
                                                <option value="22" <?php if($cur_hour_to == '22:00'){echo ' selected';}?>>22:00</option>
                                                <option value="23" <?php if($cur_hour_to == '23:00'){echo ' selected';}?>>23:00</option>
                                                <option value="24" <?php if($cur_hour_to == '24:00'){echo ' selected';}?>>00:00</option>
                                            </select>
                                        </div>
                                        
                                    </div> 


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="notes">הערות</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <textarea class="form-control" name="notes" id="notes"><?php echo $cur_notes;?></textarea>
                                        </div>
                                    </div> 


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="status">סטטוס</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <select class="form-control" name="status" onchange="change_status(this,'<?php echo $_GET['formid'];?>',this.value)">
                                                <option value="1" <?php if($cur_status == 1){echo ' selected';}?>>נשלח</option>
                                                <option value="2" <?php if($cur_status == 2){echo ' selected';}?>>בוטל</option>
                                                <option value="3" <?php if($cur_status == 3){echo ' selected';}?>>התקבל</option>
                                            </select>
                                            
                                        </div>
                                    </div> 


                                    <div class="form-group row">
                                            <div class="sending">שולח...</div>
                                            <button name="action" type="submit" id="update-form" class="btn btn btn-default" value="update-form"><?php _e('עדכן', 'profile'); ?></button>

                                            <button name="action" type="submit" id="update-send-form" class="btn btn btn-default" value="update-send-form"><?php _e('עדכן ושלח', 'profile'); ?></button>

                                            <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('ביטול', 'profile'); ?></button>
                                            
                                            
                                    </div><!-- .form-submit -->




                                    <?php } else { ?>











                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="username">שם שולח</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo get_the_author_meta('display_name');?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="ctcodes">מחקר קליני</label>
                                        <div class="col-lg-4 col-sm-8">
                                            
                                                <?php 
                                                    $ct_codes = $wpdb->get_results( "SELECT * FROM aml_clinicaltrials");
                                                    foreach ( $ct_codes as $term ) {
                                                        
                                                        if($term->ID == $cur_ctcodes){
                                                            
                                                            echo $term->name;
                                                        }
                                                    ?>
                                                  
                                                <?php 
                                                } ?>
                                            
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <p class="col-lg-2 col-sm-4" for="visits">ביקור</p>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php
                                            foreach ( $cur_visits as $term ) {

                                            $cur_visit = $wpdb->get_row( "SELECT * FROM aml_visits where ID=" .$term);
                                            echo $cur_visit->name;

                                            }
                                            ?>
                                        </div>
                                    </div>



                                    <hr />

                                    <h4>משלוח מ:</h4>    


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="sites">שם אתר</label>
                                        <div class="col-lg-4 col-sm-8">
                                            
                                                <?php 
                                                    $sites = $wpdb->get_results( "SELECT * FROM aml_sites");

                                                    foreach ( $sites as $term ) {
                                                        
                                                        
                                                        if($term->ID == $cur_sites){
                                                            echo $term->name;
                                                        }
                                                    ?>
                                                    
                                                <?php 
                                                } ?>
                                          
                                        </div>
                                    </div>                

                                    <?php 

                                        $sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $cur_sites);
                                    ?>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="address">כתובת</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $sites->address;?>
                                        </div>
                                    </div>        

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="department">מחלקה</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $sites->department;?>
                                        </div>
                                    </div>  

                                    <h4>משלוח אל:</h4>  

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="targets">יעד</label>
                                        <div class="col-lg-4 col-sm-8">
                                           <?php 
                                                    $targets = $wpdb->get_results( "SELECT * FROM aml_targets");

                                                    foreach ( $targets as $term ) {
                                                        
                                                        
                                                        if($term->ID == $cur_targets){
                                                            echo $term->name .'-'. $term->address;
                                                        }
                                                    ?>
                                                  
                                                <?php 
                                                } ?>
                                            
                                        </div>
                                    </div>  

                                    <hr />


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="contact">איש קשר</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_contact; ?>
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="phone">איש קשר - טלפון</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_contact_phone; ?>
                                        </div>
                                    </div>  


                                    <hr />



                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="pickup">סוגי שליחות</label>
                                        <div class="col-lg-4 col-sm-8">
                                            
                                                <?php 
                                                    $pickups = $wpdb->get_results( "SELECT * FROM aml_pickup_types");

                                                    foreach ( $pickups as $term ) {
                                                        
                                                    
                                                        if($term->ID == $cur_pickup){
                                                    
                                                            echo $term->name; 
                                                        }
                                                    ?>
                                                    
                                                <?php 
                                                } ?>
                                           
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="zone">אזור בארץ</label>
                                        <div class="col-lg-4 col-sm-8">
                                            
                                                <?php 
                                                    $zones = $wpdb->get_results( "SELECT * FROM aml_zones");

                                                    foreach ( $zones as $term ) {
                                                        
                                                    
                                                        if($term->ID == $cur_zone){
                                                    
                                                            echo $term->name;
                                                        }
                                                    ?>
                                                    
                                                <?php 
                                                } ?>
                                            
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="courier">חברת שליחויות<br /><small>*חברת שליחויות לפי אזור בארץ </small></label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            
                                                <?php 
                                                    $couriers = $wpdb->get_results( "SELECT * FROM aml_couriers");

                                                    foreach ( $couriers as $term ) {
                                                        
                                                        
                                                        if($term->ID == $cur_courier){
                                                            
                                                            echo $term->name;
                                                        }
                                                    ?>
                                                    
                                                <?php 
                                                } ?>
                                            
                                        </div>
                                    </div>  


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="courier_email">
                                            חברת שליחויות - Email
                                        </label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <?php echo $cur_email;?>
                                        </div>
                                    </div>  


                                    


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="date">תאריך איסוף</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_date;?>
                                        </div>
                                    </div> 


                                    <div class="form-group row">
                                        
                                        <label class="col-lg-2 col-sm-4" for="hour">שעת איסוף - מונית</label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <?php
                                            if($cur_taxi_hour){
                                                echo $cur_taxi_hour .':'. $cur_taxi_mins;
                                            }else{
                                                echo $cur_hour_from .'-'. $cur_hour_to;
                                            }
                                            ?>

                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4" for="notes">הערות</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php echo $cur_notes;?>
                                        </div>
                                    </div> 


























                                    <?php } ?>



                                    

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

    $('#updateform').submit(function(){

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

    //check_pickuptype();
    
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


    $.ajax({
     type: 'post',
     url: '../fetch/aml_fetch_visits.php',
     dataType :'json',
     data: {
      get_option:<?php echo $cur_ctcodes;?>
     },
     success: function (response) {
            var visits = <?php echo json_encode($cur_visits);?>;
            var dropdownList=$("#visits");
            dropdownList.empty();
            dropdownList.append("<option value=\"-1\" >-- Choose Clinical Trial --</option>");
            for (var index=0;index<response.length;index++)
                {
                    var selected = '';
                    if (jQuery.inArray(response[index].ID, visits) != -1){
                        selected = ' selected';
                    }
                    var listOption="<option value=\"" + response[index].ID + "\"";
                    listOption+=" "+selected+" ";
                    listOption+=">";
                    listOption+=response[index].name + "</option>";
                    dropdownList.append(listOption);
                }
    }
 }); 



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
        //dropdownList.append("<option value=\"-1\" selected=\"\">-- Choose Clinical Trial --</option>");
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

function check_courier(){
    var selected = $("#courier option:selected").val();
    //console.log(selected);
    $.ajax({
     type: 'post',
     url: '../fetch/aml_fetch_emails.php',
     data: {
      get_option:selected
     },
     success: function (response) {
        $('#courier_email').attr('value',response);
        $('#courier_email_text').text(response);
        
    }
    });
}


function check_pickuptype(){
    //$('#pickup').find('option[text="קרח"]').val();
    var selected = $("#pickup option:selected").val();
    //var courier_val = $("#courier option:selected").val();
    var ice_array = ["7","13","14","15","16","17","18","20","21","22","23"];
    console.log(selected);
    if (ice_array.indexOf(selected) !== -1){
        console.log('חברת שליחויות חייבת להיות במהירות הכל');

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
