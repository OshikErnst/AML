<?php 
/**
 * Template Name: Add Courier
 *
 */
 
 include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'add-courier' ) {
    
    
	$wpdb->insert( 
	'aml_couriers', 
	array( 
        'name' => $_POST['courier_name'],
        'email' => $_POST['courier_email'],
        'dry_ice' => $_POST['courier_dry_ice'],        

	), 
	array( 
        '%s',   
        '%s',
        '%d'
	) 
);
    
    $lastid = $wpdb->insert_id;


   
    $courier_zone = $_POST['courier_zone'];

    foreach ( $courier_zone as $term ) {
        $wpdb->insert( 
            'aml_couriers_zones', 
            array( 
                'courier_id' => $lastid,
                'zone_id' => $term  
            ), 
            array( 
                '%d',   
                '%d'
            ) 
        );
        

    }
         


	wp_redirect( home_url().'/couriers' );

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

                                <h4 class="page-title">Couriers</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>courier has been added.</p></div> <?php endif; ?>


                                        <div class="p-20">

                                        <form method="post" id="add-courier" action="<?php the_permalink(); ?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_name">Courier Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="courier_name" type="text" id="courier_name" class="form-control">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_email">Courier Email</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="courier_email" type="text" id="courier_email" class="form-control">
                                                    <small class="text-muted">Seperate multiple emails with a comma</small>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_dry_ice">Dry Ice</label>
                                                <div class="col-lg-4 col-sm-8"> 


                                                    <div class="radio radio-info form-check-inline">
                                                        
                                                        <input type="radio" name="courier_dry_ice" id="courier_dry_ice2" checked="" value="1">
                                                        <label for="courier_dry_ice2"> Yes </label>

                                                        <input type="radio" name="courier_dry_ice" id="courier_dry_ice1" checked="" value="0">
                                                        <label for="courier_dry_ice1"> No </label>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="Courier_zone">Courier_zone</label>
                                                <div class="col-lg-4 col-sm-8"> 

                                                    <select name="courier_zone[]" multiple="multiple" class="form-control select2 select2-multiple"  data-placeholder="Choose ...">
                                                        
                                                        <?php
                                                        global $wpdb;
                                                        $courier_zone = $wpdb->get_results( "SELECT * FROM aml_zones");
                                                        
                                                        ?>
                                                        <?php $count = count($courier_zone); if ( $count > 0 ){ 
                                                            
                                                            foreach ( $courier_zone as $term ) {
                                                                
                                                            ?>
                                                            <option value="<?php echo $term->ID;?>"><?php echo $term->name; ?></option>
                                                            
                                                        <?php } 
                                                        } ?>
                                                    </select>

                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="add-courier" type="submit" id="add-courier" class="btn btn-default"><?php _e('Add', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="add-courier" />

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