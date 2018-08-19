<?php 
/**
 * Template Name: Shipping Type Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-shipping_type' ) {

   $wpdb->update( 
    'aml_shipping_types', 
    array( 
        'name' => $_POST['shipping_type_name']

        
    ), 
    array( 'ID' => $_POST['shipping_type_id'] ), 
    array( 
        '%s'  
    ), 
    array( '%d' ) 
);


    wp_redirect( get_permalink().'/?shipping_typeid='.$_POST['shipping_type_id'].'&updated=true' ); exit;

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

                                <h4 class="page-title">Shipping Types</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>shipping type has been updated.</p></div> <?php endif; ?>

        

                                        <?php 
                                        global $wpdb;
                                        $shipping_type = $wpdb->get_row( "SELECT * FROM aml_shipping_types where ID=" . $_REQUEST['shipping_typeid']);?>


        

                                        <div class="p-20">

                                        <form method="post" id="updateshipping_type" action="<?php the_permalink(); ?>?shipping_typeid=<?php echo $_REQUEST['zoneid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="shipping_type_id">Shipping Type ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                <input type="hidden" name="shipping_type_id" class="form-control" value="<?php echo $shipping_type->ID; ?>" />
                                                <?php echo $shipping_type->ID; ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="shipping_type_name">Shipping Type Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="shipping_type_name" type="text" id="shipping_type_name" class="form-control" value="<?php echo $shipping_type->name; ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="update-shipping_type" type="submit" id="update-shipping_type" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-shipping_type" />
        
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