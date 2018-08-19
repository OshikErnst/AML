<?php 
/**
 * Template Name: Add Pickup Type
 *
 */
 
 include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-pickup_type' ) {

	
	$wpdb->insert( 
	'aml_pickup_types', 
	array( 
        'name' => $_POST['pickup_type_name'],
        'description' => $_POST['pickup_type_description'],
        'taxi' => $_POST['pickup_type_taxi'],

	), 
	array( 
        '%s',   
        '%s',
        '%d'
	) 
);


	wp_redirect( home_url().'/pickup-types' );

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

                                <h4 class="page-title">Pickup Types</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>pickup type has been added.</p></div> <?php endif; ?>


                                        <div class="p-20">

                                        <form method="post" id="add-pickup_type" action="<?php the_permalink(); ?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_name">Pickup Type Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="pickup_type_name" type="text" id="pickup_type_name" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_description">Pickup Type Description</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <textarea type="text" class="form-control" name="pickup_type_description"></textarea> 
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_taxi">Pickup Type Taxi</label>
                                                <div class="col-lg-4 col-sm-8"> 


                                                    <div class="radio radio-info form-check-inline">
                                                        
                                                        <input type="radio" name="pickup_type_taxi" id="pickup_type_taxi2" checked="" value="1">
                                                        <label for="pickup_type_taxi2"> Yes </label>

                                                        <input type="radio" name="pickup_type_taxi" id="pickup_type_taxi1" value="0">
                                                        <label for="pickup_type_taxi1"> No </label>
                                                    </div>

                                                </div>
                                            </div>

 

                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="add-pickup_type" type="submit" id="add-pickup_type" class="btn btn-default"><?php _e('Add', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="add-pickup_type" />

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