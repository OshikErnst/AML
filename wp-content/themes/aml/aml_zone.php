<?php 
/**
 * Template Name: Zone Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-zone' ) {

   $wpdb->update( 
    'aml_zones', 
    array( 
        'name' => $_POST['zone_name']

        
    ), 
    array( 'ID' => $_POST['zone_id'] ), 
    array( 
        '%s'  
    ), 
    array( '%d' ) 
);


    wp_redirect( get_permalink().'/?zoneid='.$_POST['zone_id'].'&updated=true' ); exit;

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

                                <h4 class="page-title">Zones</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>zone has been updated.</p></div> <?php endif; ?>

        

                                        <?php 
                                        global $wpdb;
                                        $zone = $wpdb->get_row( "SELECT * FROM aml_zones where ID=" . $_REQUEST['zoneid']);?>


        

                                        <div class="p-20">

                                        <form method="post" id="updatezone" action="<?php the_permalink(); ?>?zoneid=<?php echo $_REQUEST['zoneid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="zone_id">Zone ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                <input type="hidden" name="zone_id" class="form-control" value="<?php echo $zone->ID; ?>" />
                                                <?php echo $zone->ID; ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="zone_name">Zone Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="zone_name" type="text" id="zone_name" class="form-control" value="<?php echo $zone->name; ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="update-zone" type="submit" id="update-zone" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-zone" />
        
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