<?php 
/**
 * Template Name: Add World Courier
 *
 */
 
 include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-world-courier' ) {
    
    
	$wpdb->insert( 
	'aml_world_couriers', 
	array( 
        'name' => $_POST['world_courier_name'],
        'email' => $_POST['world_courier_email']

	), 
	array( 
        '%s',   
        '%s'
	) 
);
    
         


	wp_redirect( home_url().'/world-couriers' );

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

                                <h4 class="page-title">World Couriers</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>world courier has been added.</p></div> <?php endif; ?>


                                        <div class="p-20">

                                        <form method="post" id="add-world-courier" action="<?php the_permalink(); ?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_name">World Courier Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="world_courier_name" type="text" id="world_courier_name" class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_email">World Courier Email</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="world_courier_email" type="text" id="world_courier_email" class="form-control">
                                                    <small class="text-muted">Seperate multiple emails with a comma</small>
                                                </div>
                                            </div>





                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="add-world-courier" type="submit" id="add-world-courier" class="btn btn-default"><?php _e('Add', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="add-world-courier" />

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