<?php 
/**
 * Template Name: Pickup Type Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-pickup_type' ) {
    
    

   $wpdb->update( 
    'aml_pickup_types', 
    array( 
        'name' => $_POST['pickup_type_name'],
        'description' => $_POST['pickup_type_description'],
        'taxi' => $_POST['pickup_type_taxi'],
        
    ), 
    array( 'ID' => $_POST['pickup_type_id'] ), 
    array( 
        '%s',   
        '%s',
        '%d'
    ), 
    array( '%d' ) 
);


    wp_redirect( get_permalink().'/?pickup_typeid='.$_POST['pickup_type_id'].'&updated=true' ); exit;

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

                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>pickup type has been updated.</p></div> <?php endif; ?>


                                        <?php 
                                        global $wpdb;
                                        $pickup_type = $wpdb->get_row( "SELECT * FROM aml_pickup_types where ID=" . $_REQUEST['pickup_typeid']);

                                        ?>


        

                                        <div class="p-20">

                                        <form method="post" id="updatepickup_type" action="<?php the_permalink(); ?>?pickup_typeid=<?php echo $_REQUEST['pickup_typeid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_id">ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="pickup_type_id" type="hidden" id="pickup_type_id" class="form-control" value="<?php echo $pickup_type->ID; ?>">
                                                    <?php echo $pickup_type->ID; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_name">Pickup Type Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="pickup_type_name" type="text" id="pickup_type_name" class="form-control" value="<?php echo $pickup_type->name; ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_description">Pickup Type Description</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <textarea type="text" class="form-control" name="pickup_type_description"><?php echo $pickup_type->description; ?></textarea> 
                                                </div>
                                            </div>             



                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_taxi">Pickup Type Taxi</label>
                                                <div class="col-lg-4 col-sm-8"> 


                                                    <div class="radio radio-info form-check-inline">
                                                        
                                                        <input type="radio" name="pickup_type_taxi" id="pickup_type_taxi2" value="1" <?php if($pickup_type->taxi=='1'){echo ' checked'; }?>>
                                                        <label for="pickup_type_taxi2"> Yes </label>

                                                        <input type="radio" name="pickup_type_taxi" id="pickup_type_taxi1" value="0" <?php if($pickup_type->taxi=='0'){echo ' checked'; }?>>
                                                        <label for="pickup_type_taxi1"> No </label>
                                                    </div>

                                                </div>
                                            </div>                               




                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="update-pickup_type" type="submit" id="update-pickup_type" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-pickup_type" />
        
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