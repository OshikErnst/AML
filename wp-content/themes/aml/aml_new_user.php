<?php 
/**
 * Template Name: Add User
 *
 */
 include('aml_checklogin.php');


global $wp_roles;


/* Load the registration file. */
require_once( ABSPATH . WPINC . '/registration.php' );
$error = array();    
/* If profile was added, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-user' ) {


    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] )
            $pass = $_POST['pass1'];
        else
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
    }

    /* Update user information. */

    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif(email_exists(esc_attr( $_POST['email'] )) )
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');
        else{
            $email = esc_attr( $_POST['email'] );
        }
    }

    

    if ( !empty( $_POST['user-name'] ) )
        $user_name = esc_attr( $_POST['user-name'] );
        $user_name = preg_replace('/\s+/', '', $user_name);

    if ( !empty( $_POST['first-name'] ) )
        $first_name = esc_attr( $_POST['first-name'] );
    if ( !empty( $_POST['last-name'] ) )
        $last_name = esc_attr( $_POST['last-name'] );
    if ( !empty( $_POST['phonenumber'] ) )
        $phonenumber = $_POST['phonenumber'];

    if ( !empty( $_POST['ctcodes'] ) )
        $ctcodes = $_POST['ctcodes'];

    if ( !empty( $_POST['sites'] ) )     
        $sites = $_POST['sites'];   

    if ( !empty( $_POST['roles'] ) )     
        $roles = $_POST['roles'];   

    
    
    


    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        
        $user_data = array(
        'ID' => '',
        'user_pass' => $pass,
        'user_login' => $user_name,
        'user_nicename' => $first_name . '' . $last_name,
        'user_email' => $email,
        'display_name' => $first_name . ' ' . $last_name,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'user_registered' => date('Y-m-d H:i:s'),
        'role' => $roles // Use default role or another role, e.g. 'editor'
        );
        $user_id = wp_insert_user( $user_data );
        
        //On success
        if ( ! is_wp_error( $user_id ) ) {

            //wp_update_user( array ('ID' => $user_id 'role' => 'editor') ) ;
            update_user_meta( $user_id, 'phonenumber', $_POST['phonenumber'] );
            update_user_meta( $user_id, 'ctcodes', $_POST['ctcodes'] );
            update_user_meta( $user_id, 'sites', $_POST['sites'] );

            wp_redirect( home_url().'/users' );
            exit;
        }else{
            if ( is_wp_error( $user_id ) ) {
               $error = $user_id->get_error_message();

               //echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
            }
        }

       


        //wp_redirect( home_url().'/users' );
        //exit;
     
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

                                <h4 class="page-title">Users</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>profile has been added.</p></div> <?php endif; ?>

                                        <?php if ( count($error) > 0 )
                                            echo '<p class="error">';
                                            if (is_array($error)){

                                                foreach ($error as $value) {
                                                    echo $value;
                                                    echo '<br />';
                                                }
                                            }else{
                                                echo $error;
                                            }
                                             echo '</p>';


                                          
                                        ?>  


                                        <div class="p-20">

                                        <form method="post" id="adduser_form" action="<?php the_permalink(); ?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="user-name">User Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="user-name" type="text" id="user-name" class="form-control">
                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="first-name">First Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="first-name" type="text" id="first-name" class="form-control">
                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="last-name">Last Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="last-name" type="text" id="last-name" class="form-control">
                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="email">E-mail</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="email" type="email" id="email" class="form-control">
                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pass1">Password</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="pass1" type="password" id="pass1" class="form-control">
                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pass2">Repeat Password</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="pass2" type="password" id="pass2" class="form-control">
                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="phonenumber">Phone Number</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="phonenumber" type="text" id="phonenumber" class="form-control">
                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="ctcodes">CT codes</label>
                                                <div class="col-lg-4 col-sm-8"> 

                                                                   
                                                <select name="ctcodes[]" multiple="multiple" multiple class="form-control select2 select2-multiple" data-placeholder="Choose ..." required="">
                                                    <?php
                                                    global $wpdb;
                                                    $ct_codes = $wpdb->get_results( "SELECT * FROM aml_clinicaltrials order by name");
                                                    
                                                    ?>
                                                    <?php $count = count($ct_codes); if ( $count > 0 ){ 
                                                        
                                                        foreach ( $ct_codes as $term ) {
                                                            

                                                        ?>
                                                        <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
                                                        
                                                    <?php } 
                                                    } ?>
                                                </select>

                                                </div>
                                            </div>  




                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="sites">Sites</label>
                                                <div class="col-lg-4 col-sm-8"> 
                       
                                                <select  name="sites" class="form-control select2" data-placeholder="Choose ..." required="">
                                                    <option value="">-- Choose A Site --</option>
                                                    <?php
                                                    global $wpdb;
                                                    $sites = $wpdb->get_results( "SELECT * FROM aml_sites");
                                                    
                                                    ?>
                                                    <?php $count = count($sites); if ( $count > 0 ){ 
                                                        
                                                        foreach ( $sites as $term ) {
                                                            
                                                        ?>
                                                        <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?> - <?php echo $term->department; ?></option>
                                                        
                                                    <?php } 
                                                    } ?>
                                                </select>

                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="roles">Roles</label>
                                                <div class="col-lg-4 col-sm-8"> 

                                                                        
                                                <select  name="roles" class="form-control">
                                                    
                                                        <option value="subscriber">User</option>
                                                        <option value="contributor">Receptionist</option>
                                                        <option value="administrator">Admin</option>
                                                        
                                                    
                                                </select>

                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="adduser" type="submit" id="adduser" class="btn btn-default"><?php _e('Add', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>

                                                
                                                <input name="action" type="hidden" id="action" value="add-user" />
                                            </div><!-- .form-submit -->
                                     

                                        </form><!-- #adduser -->
                                    </div>
                                    
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

<?php if ( count($error) > 0 ) { ?>

<script>
$('#user-name').val('<?php echo $_POST['user-name'];?>');
$('#first-name').val('<?php echo $_POST['first-name'];?>');
$('#last-name').val('<?php echo $_POST['last-name'];?>');
$('#email').val('<?php echo $_POST['email'];?>');
$('#pass1').val('<?php echo $_POST['pass1'];?>');
$('#pass2').val('<?php echo $_POST['pass2'];?>');
$('#phonenumber').val('<?php echo $_POST['phonenumber'];?>');

$('[name=ctcodes]').val('<?php echo $_POST['ctcodes[]'];?>').trigger('change');

$('[name=sites]').val('<?php echo $_POST['sites'];?>').trigger('change');

$('#roles').val('<?php echo $_POST['roles'];?>');


</script>



<?php } ?>    