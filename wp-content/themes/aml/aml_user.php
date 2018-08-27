<?php 
/**
 * Template Name: User Page
 *
 */
 
include('aml_checklogin.php');
/* Get user info. */
global $wp_roles;
//get_currentuserinfo();
$userid = $_REQUEST['userid'];
$user_info = get_userdata($userid);
/* Load the registration file. */
require_once( ABSPATH . WPINC . '/registration.php' );
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] ){
            add_filter( 'send_password_change_email', '__return_false' );
            wp_update_user( array( 'ID' => $user_info->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
        }else{
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
        }
    }

    /* Update user information. */

    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif(email_exists(esc_attr( $_POST['email'] )) != $user_info->id )
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');
        else{
            wp_update_user( array ('ID' => $user_info->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $user_info->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($user_info->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['roles'] ) )
        //update_user_meta($user_info->ID, 'role', esc_attr( $_POST['roles'] ) );
        wp_update_user( array( 'ID' => $user_info->ID, 'role' => $_POST['roles'] ) );
        
        $display_name = $_POST['first-name'] . ' ' . $_POST['last-name'];
        wp_update_user( array( 'ID' => $user_info->ID, 'display_name' => $display_name ) );
        

    

    update_user_meta( $user_info->ID, 'phonenumber', $_POST['phonenumber'] );
    update_user_meta( $user_info->ID, 'ctcodes', $_POST['ctcodes'] );
    update_user_meta( $user_info->ID, 'sites', $_POST['sites'] );


    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $user_info->ID);
        wp_redirect( get_permalink().'/?userid='.$user_info->ID.'&updated=true' ); exit;
     
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

                                <h4 class="page-title">Users - <?php echo $user_info->user_login ?></h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">
                                                                         

                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>profile has been updated.</p></div> <?php endif; ?>
                                        <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>

                                        <div class="p-20">

                                        <form class="form-horizontal" role="form" method="post" id="adduser" action="<?php the_permalink(); ?>?userid=<?php echo $user_info->ID;?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="first-name">First Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="first-name" type="text" id="first-name" class="form-control" value="<?php the_author_meta( 'first_name', $user_info->ID ); ?>">
                                                </div>
                                            </div>  

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="last-name">Last Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="last-name" type="text" id="last-name" class="form-control" value="<?php the_author_meta( 'last_name', $user_info->ID ); ?>">
                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="email">E-mail</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="email" type="email" id="email" class="form-control" value="<?php the_author_meta( 'user_email', $user_info->ID ); ?>">
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
                                                    <input name="phonenumber" type="text" id="phonenumber" class="form-control" value="<?php echo esc_attr( get_the_author_meta( 'phonenumber', $user_info->ID ) ); ?>">
                                                </div>
                                            </div>  


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="ctcodes">CT codes</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    
                                                    <?php 

                                                    $current_arr = get_the_author_meta( 'ctcodes', $user_info->ID ); ?>
                                                    
                                                    <select  name="ctcodes[]" multiple="multiple" class="form-control select2 select2-multiple" data-placeholder="Choose ...">
                                                        <?php
                                                        global $wpdb;
                                                        $ct_codes = $wpdb->get_results( "SELECT * FROM aml_clinicaltrials order by name");
                                                        
                                                        ?>
                                                        <?php $count = count($ct_codes); if ( $count > 0 ){ 
                                                            
                                                            foreach ( $ct_codes as $term ) {
                                                                $selected = '';
                                                                if(in_array($term->ID,$current_arr)){
                                                                    $selected = " selected";
                                                                }

                                                            ?>
                                                            <option value="<?php echo $term->ID;?>" <?php echo $selected;?>><?php echo $term->name; ?></option>
                                                            
                                                        <?php } 
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>




                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="sites">Sites</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    
                                                    <?php 

                                                    $current_arr = get_the_author_meta( 'sites', $user_info->ID ); ?>
                                                    
                                                    <select  name="sites" class="form-control select2" data-placeholder="Choose ...">
                                                        <option value="-1">-- Choose A Site --</option>
                                                        <?php
                                                        global $wpdb;
                                                        $sites = $wpdb->get_results( "SELECT * FROM aml_sites");
                                                        
                                                        ?>
                                                        <?php $count = count($sites); if ( $count > 0 ){ 
                                                            
                                                            foreach ( $sites as $term ) {
                                                                
                                                                $selected = '';
                                                                if($term->ID==$current_arr){
                                                                    $selected = " selected";
                                                                }
                                                                
                                                            ?>
                                                            <option value="<?php echo $term->ID;?>" <?php echo $selected;?>><?php echo $term->name; ?> - <?php echo $term->department; ?></option>
                                                            
                                                        <?php } 
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="roles">Roles</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    
                                                    <select  name="roles" class="form-control">
                                                    
                                                        <option value="subscriber" <?php if(in_array("subscriber",$user_info->roles)){ echo " selected";}?>>User</option>
                                                        <option value="contributor" <?php if(in_array("contributor",$user_info->roles)){ echo " selected";}?>>Receptionist</option>
                                                        <option value="administrator" <?php if(in_array("administrator",$user_info->roles)){ echo " selected";}?>>Admin</option>
                                                        
                                                    
                                                    </select>
                                                </div>
                                            </div>


                                            <?php 
                                                //action hook for plugin and extra fields
                                                do_action('edit_user_profile',$user_info); 
                                            ?>
                                            
                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="updateuser" type="submit" id="updateuser" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <?php wp_nonce_field( 'update-user_'. $user_info->ID ) ?>
                                                <input name="action" type="hidden" id="action" value="update-user" />
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
