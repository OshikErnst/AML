<?php 
/**
 * Template Name: Add Int Form
 *
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

include('aml_checklogin.php');
/* Get user info. */
global $wp_roles,$wpdb;
$user_info = get_currentuserinfo();


$error = array();    

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && ($_POST['action'] == 'send-form' || $_POST['action'] == 'create-form' )) {

    
    $post_name = 'International Form Sent by ' . $_POST['username'] . ' on ' . date("F j, Y, g:i a"); 

    $my_post = array(
    'post_title' => $post_name,
    'post_content' => $post_name,
    'post_status' => 'publish',
    'post_category' => array( 2 ),
    'post_author'   => $_POST['userid']
    );
    $the_post_id = wp_insert_post( $my_post );

    //save creation date
    $dt = new DateTime('now', new DateTimezone('Asia/Jerusalem'));
    add_post_meta( $the_post_id, 'creation_date', $dt->format('j/n/Y, H:i'));



    add_post_meta( $the_post_id, 'ctcodes', $_POST['ctcodes'] );
    add_post_meta( $the_post_id, 'int_targets', $_POST['int_targets'] );
    add_post_meta( $the_post_id, 'awb', $_POST['awb'] );
    add_post_meta( $the_post_id, 'shipment_number', $_POST['shipment_number'] );
    add_post_meta( $the_post_id, 'outbound_shipment_date', $_POST['outbound_shipment_date'] );

    add_post_meta( $the_post_id, 'hour_from', $_POST['hour_from'] );
    add_post_meta( $the_post_id, 'hour_to', $_POST['hour_to'] );

    add_post_meta( $the_post_id, 'world_courier', $_POST['world_courier'] );
    add_post_meta( $the_post_id, 'shipping_type', $_POST['shipping_type'] );

    if ($_POST['action'] == 'send-form'){



    $mail_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $_POST['ctcodes']);
    $mail_int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where ID = " . $_POST['int_targets']);
    $mail_courier = $wpdb->get_row( "SELECT * FROM aml_world_couriers where ID = " . $_POST['world_courier']);
    $mail_shipping_type = $wpdb->get_row( "SELECT * FROM aml_shipping_types where ID = " . $_POST['shipping_type']);

    $mail_hour_from = $_POST['hour_from'].':00';
    $mail_hour_to = $_POST['hour_to'].':00';
    $mail_hours = $mail_hour_from . '-' . $mail_hour_to;
    


    /*$current_user = wp_get_current_user();
    
    $cur_user_email = $current_user->user_email;*/

    /* EMAIL */

   $message = 'We would like to order a pickup with the following details: <br /><br /><table cellpadding=10 cellspasing=10> <tr> <td>מחקר</td><td>'.$mail_ct_code->name.'</td><td>Clinical Trial</td></tr><tr> <td>יעד משלוח</td><td>'.$mail_int_targets->name.'</td><td>Destination of shipment</td></tr><tr> <td>מספר משלוח</td><td>'.$_POST['shipment_number'].'</td><td>Shipment Number</td></tr><tr> <td>תאריך משלוח</td><td>'.$_POST['outbound_shipment_date'].'</td><td>Outbound shipment date</td></tr><tr> <td>שעת איסוף</td><td>'.$mail_hours.'</td><td>Pickup time</td></tr><tr> <td>חברת שילוח</td><td>'.$mail_courier->name.'</td><td>Courier</td></tr><tr> <td>סוג משלוח</td><td>'.$mail_shipping_type->name.'</td><td>Shipping Type</td></tr><tr> <td>--- </td><td>contact us&nbsp;ליצירת קשר  </td><td>--- </td></tr><tr> <td>---</td><td>amlcustserv@aml.co.il</td><td>---</td></tr><tr> <td>---</td><td>099561268</td><td>---</td></tr><tr><td>מספר הזמנה</td><td style="text-align:center;">'.$the_post_id.'</td><td>Order Num</td></tr></table>';

    

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

    //add current user email too
    /*if($cur_user_email){
    $mail->AddBCC($cur_user_email, $cur_user_email);          
    } */     
           
    

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

    wp_redirect( home_url().'/int-forms?sent=true' );
   
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

                                    <?php if ( $_GET['sent'] == 'true' ) : ?> <div id="message" class="text-success"><p>form sent</p></div> <?php endif; ?>

                                    <form method="post" id="newform" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" >

                                    <div class="form-group row">
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="username" type="hidden" id="username" value="<?php the_author_meta( 'user_nicename', $user_info->ID ); ?>" />
                                            <input type="hidden" name="userid" value="<?php echo $user_info->ID;?>" />
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="ctcodes">Clinical Trial</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <?php $ct_codes = $wpdb->get_results( "SELECT * FROM aml_clinicaltrials" ); ?>
                                            <select  name="ctcodes" onchange="fetch_select('int_targets','int_targets','select',this.value);" class="form-control" required="">
                                                <option value="" disabled="" selected="">-- Choose Clinical Trial --</option>
                                                <?php $count = count($ct_codes); if ( $count > 0 ){ 
                                                    foreach ( $ct_codes as $term ) {
                                                        ;

                                                    ?>
                                                    <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
                                                <?php } 
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
                                            <input class="form-control" name="awb" type="text" id="awb" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="shipment_number">Shipment Number</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input class="form-control" name="shipment_number" type="text" id="shipment_number" value="" />
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="outbound_shipment_date">Outbound Shipment Date </label>
                                        <div class="col-lg-4 col-sm-8">


                                            <input type="text" class="form-control" value="<?php echo date("d/m/Y"); ?>" name="outbound_shipment_date" required id="outbound_shipment_date">
                                        </div>
                                    </div>




                                    <div  class="form-group row"  id="shipment_hours">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="hour">Pickup Hour</label>
                                        <div class="col-lg-4 col-sm-8 input-group">
                                            <span class="input-group-addon bg-custom b-0 text-white">From</span>
                                            <select class="form-control" name="hour_from" type="text" id="hour_from">
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

                                            </select>
                                            <span class="input-group-addon bg-custom b-0 text-white">To</span>
                                            <select class="form-control" name="hour_to" type="text" id="hour_to">
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
                                                        ;

                                                    ?>
                                                    <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
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
                                                        ;

                                                    ?>
                                                    <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
                                                <?php } 
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-2 col-sm-4 col-form-label" for="file_attached">Add File</label>
                                        <div class="col-lg-4 col-sm-8">
                                            <input type="file" class="filestyle" name="file_attached" id="file_attached" data-buttonname="btn-white">

                                        </div>
                                        
                                        
                                    </div>



                                    <div class="form-group row">
                                            <div class="sending">שולח...</div>
                                            <?php echo $referer; ?>
                                            <button name="action" type="submit" id="create-form" class="btn btn-default" value="create-form"><?php _e('Create', 'profile'); ?></button>

                                            <button name="action" type="submit" id="send-form" class="btn btn-default" value="send-form"><?php _e('Create & Send', 'profile'); ?></button>

                                            <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>

    
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
<?php get_footer();?>

 <script>

    $( document ).ready(function() {
    
        $("#outbound_shipment_date").datepicker({
            <?php if(!current_user_can('administrator')){?> startDate: "today", <?php }?> 
            format: 'dd/mm/yyyy'
        });


        //Log form enter

        var currentTime = moment().format("HH:mm");
            <?php global $current_user;
                  get_currentuserinfo();
        ?>
        var currentUser = "<?php echo $current_user->display_name;?>";
        var currentPage = "כניסה לטופס חול";

        $.ajax({
            type: 'post',
            url: '<?php echo bloginfo('url');?>/fetch/aml_log_enter_form.php',
            
            data: {
             currentTime:currentTime,
             currentUser:currentUser,
             LogType:currentPage

            }
        });


        $('#newform').submit(function(){
            var hour_from = $('#hour_from').val();
            var hour_to = $('#hour_to').val();
            
            
            if ( Number(hour_to) <= Number(hour_from) ) { 
               alert("Please fix pickup hours");     
               return false;
            }

            
            $('.sending').show();
        });
    });


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
        dropdownList.append("<option value=\"-1\" disabled=\"\" selected=\"\">-- Please Choose --</option>");
        for (var index=0;index<response.length;index++)
            {
                var listOption="<option value=\"" + response[index].id;
                listOption+="\">";
                listOption+=response[index].name + "</option>";
                dropdownList.append(listOption);
            }

}



 }
 });
}


function check_pickuptype(){
    //$('#pickup').find('option[text="קרח"]').val();
    var selected = $("#pickup option:selected").text();
    if (selected.indexOf("קרח") >= 0){
        console.log('חברת שליחויות חייבת להיות במהירות הכל');
        $('#courier').val('6');
        $('.courier_text').text('במהירות הכל');
        
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