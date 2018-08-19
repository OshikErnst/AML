<?php 
/**
 * Template Name: Target Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-target' ) {

   $wpdb->update( 
    'aml_targets', 
    array( 
        'name' => $_POST['target_name'],
        'address' => $_POST['target_address'],


        
    ), 
    array( 'ID' => $_POST['target_id'] ), 
    array( 
        '%s',
        '%s'  
    ), 
    array( '%d' ) 
);


    wp_redirect( get_permalink().'/?targetid='.$_POST['target_id'].'&updated=true' ); exit;

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

                                <h4 class="page-title">Targets</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>target has been updated.</p></div> <?php endif; ?>

        

                                        <?php 
                                        global $wpdb;
                                        $target = $wpdb->get_row( "SELECT * FROM aml_targets where ID=" . $_REQUEST['targetid']);?>


        

                                        <div class="p-20">

                                        <form method="post" id="updatetarget" action="<?php the_permalink(); ?>?targetid=<?php echo $_REQUEST['targetid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="target_id">Target ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="target_id" type="hidden" id="target_id" class="form-control" value="<?php echo $target->ID; ?>">
                                                    <?php echo $target->ID; ?>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="target_name">Target Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="target_name" type="text" id="target_name" class="form-control" value="<?php echo $target->name; ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="target_address">Target Address</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="target_address" type="text" id="target_address" class="form-control" value="<?php echo $target->address; ?>">
                                                </div>
                                            </div>                                            


    
  

                                          


                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="update-target" type="submit" id="update-target" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-target" />
        
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