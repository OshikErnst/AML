<?php 
/**
 * Template Name: Add Site
 *
 */
 
 include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-site' ) {

	
	$wpdb->insert( 
	'aml_sites', 
	array( 
		'name' => $_POST['site_name'],
        'department' => $_POST['site_department'],		
        'address' => $_POST['site_address'],
        'zone' => $_POST['site_zone'],
        'time_limit' => $_POST['site_time_limit'],

	), 
	array( 
		'%s',   
        '%s',
        '%s', 
        '%d',  
        '%s'  
	) 
);


	wp_redirect( home_url().'/sites' );

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

                                <h4 class="page-title">Sites</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>site has been added.</p></div> <?php endif; ?>


                                        <div class="p-20">

                                        <form method="post" id="add-site" action="<?php the_permalink(); ?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="site_name">Site Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="site_name" type="text" id="site_name" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="site_department">Site Department</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="site_department" type="text" id="site_department" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="site_address">Site Address</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="site_address" type="text" id="site_address" class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="site_zone">Site Zone</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    
										            <select name="site_zone" class="form-control">
										                <option value="-1">-- Choose A Zone --</option>
										                <?php
										                global $wpdb;
										                $site_zone = $wpdb->get_results( "SELECT * FROM aml_zones");
										                
										                ?>
										                <?php $count = count($site_zone); if ( $count > 0 ){ 
										                    
										                    foreach ( $site_zone as $term ) {
										                        
										                    ?>
										                    <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
										                    
										                <?php } 
										                } ?>
										            </select>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="site_time_limit">Site Time Limit</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="site_time_limit" type="time" id="site_time_limit" class="form-control">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="add-site" type="submit" id="add-site" class="btn btn-default"><?php _e('Add', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="add-site" />

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