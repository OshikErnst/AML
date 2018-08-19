<?php 
/**
 * Template Name: Courier Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-courier' ) {
    
    
    
   $wpdb->update( 
    'aml_couriers', 
    array( 
        'name' => $_POST['courier_name'],
        'email' => $_POST['courier_email'],
        'dry_ice' => $_POST['courier_dry_ice'],  
        
    ), 
    array( 'ID' => $_POST['courier_id'] ), 
    array( 
        '%s',   
        '%s',
        '%d'
    ), 
    array( '%d' ) 
);


   $wpdb->delete( 'aml_couriers_zones', array( 'courier_id' => $_POST['courier_id'] ) );

   $courier_zone = $_POST['courier_zone'];
   

    foreach ( $courier_zone as $term ) {
        $wpdb->insert( 
            'aml_couriers_zones', 
            array( 
                'courier_id' => $_POST['courier_id'],
                'zone_id' => $term  
            ), 
            array( 
                '%d',   
                '%d'
            ) 
        );
        

    }


    wp_redirect( get_permalink().'/?courierid='.$_POST['courier_id'].'&updated=true' ); exit;

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

                                     
                                <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>courier has been updated.</p></div> <?php endif; ?>

        

                                        <?php 
                                        global $wpdb;
                                        $courier = $wpdb->get_row( "SELECT * FROM aml_couriers where ID=" . $_REQUEST['courierid']);

                                        ?>


        

                                        <div class="p-20">

                                        <form method="post" id="updatecourier" action="<?php the_permalink(); ?>?courierid=<?php echo $_REQUEST['courierid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="pickup_type_id">Courier ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="courier_id" type="hidden" id="courier_id" class="form-control" value="<?php echo $courier->ID; ?>">
                                                    <?php echo $courier->ID; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_name">Courier Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="courier_name" type="text" id="courier_name" class="form-control" value="<?php echo $courier->name; ?>">
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_email">Courier Email</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="courier_email" type="text" id="courier_email" class="form-control" value="<?php echo $courier->email; ?>">
                                                    <small class="text-muted">Seperate multiple emails with a comma</small>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_dry_ice">Dry Ice</label>
                                                <div class="col-lg-4 col-sm-8"> 


                                                    <div class="radio radio-info form-check-inline">
                                                        
                                                        <input type="radio" name="courier_dry_ice" id="courier_dry_ice2" value="1" <?php if($courier->dry_ice=='1'){echo ' checked'; }?>>
                                                        <label for="courier_dry_ice2"> Yes </label>

                                                        <input type="radio" name="courier_dry_ice" id="courier_dry_ice1" value="0" <?php if($courier->dry_ice=='0'){echo ' checked'; }?>>
                                                        <label for="courier_dry_ice1"> No </label>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="courier_zone">Courier Zone</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <?php 

                                                    //$current_arr = $courier->zone;
                                                    $current_zones = $wpdb->get_results( "SELECT zone_id FROM aml_couriers_zones where courier_id=".$courier->ID); 
                                                
                                                    ?>
                                                    
                                                    <select name="courier_zone[]" multiple="multiple" class="form-control select2 select2-multiple" data-placeholder="Choose ...">
                                                        
                                                        <?php
                                                        global $wpdb;
                                                        $courier_zone = $wpdb->get_results( "SELECT * FROM aml_zones");
                                                        
                                                        ?>
                                                        <?php $count = count($courier_zone); if ( $count > 0 ){ 
                                                            
                                                            foreach ( $courier_zone as $term ) {

                                                                $selected = '';
                                                                foreach($current_zones as $obj)
                                                                {
                                                                    if ($obj->zone_id == $term->ID)
                                                                    {
                                                                        $selected = " selected";
                                                                        break;
                                                                    }
                                                                }

                                                            ?>
                                                            <option value="<?php echo $term->ID;?>" <?php echo $selected;?>><?php echo $term->name; ?></option>
                                                            
                                                        <?php } 
                                                        } ?>
                                                    </select>


                                                </div>
                                            </div>

                                          


                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="update-courier" type="submit" id="update-courier" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-courier" />
        
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