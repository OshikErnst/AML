<?php 
/**
 * Template Name: Visit Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-visit' ) {
    
    $ct_codes = serialize($_POST['ctcodes']);
    $pickup_types = serialize($_POST['pickup_types']);

    

    if($_POST['visit_overseas'] == 'on'){
        $visit_overseas = '1';
    }else{
        $visit_overseas = '0';
    }

   $wpdb->update( 
    'aml_visits', 
    array( 
        'name' => $_POST['visit_name'],
        'clinical_trial' => $_POST['visit_ct'],
        'overseas' => $visit_overseas
        
    ), 
    array( 'ID' => $_POST['visit_id'] ), 
    array( 
        '%s',   
        '%d',
        '%s'
    ), 
    array( '%d' ) 
);


    wp_redirect( get_permalink().'/?visitid='.$_POST['visit_id'].'&updated=true' ); exit;

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

                                <h4 class="page-title">Visits</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>visit has been updated.</p></div> <?php endif; ?>

                                        <?php 
                                        global $wpdb;
                                        $visit = $wpdb->get_row( "SELECT * FROM aml_visits where ID=" . $_REQUEST['visitid']);
                                        ?>

        

                                        <div class="p-20">

                                        <form method="post" id="updatevisit" action="<?php the_permalink(); ?>?visitid=<?php echo $_REQUEST['siteid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="visit_id">ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="visit_id" type="hidden" id="visit_id" class="form-control" value="<?php echo $visit->ID; ?>">
                                                    <?php echo $visit->ID; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="visit_name">Visit Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="visit_name" type="text" id="visit_name" class="form-control" value="<?php echo $visit->name; ?>">
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="visit_ct">Clinical Trial</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <?php 

                                                    $current_arr = $visit->clinical_trial; ?>
                                                                            
                                                    <select  name="visit_ct" class="form-control" required="">
                                                        <option value="-1">-- Choose A Clinical Trial --</option>
                                                        <?php
                                                        global $wpdb;
                                                        $ct_codes = $wpdb->get_results( "SELECT * FROM aml_clinicaltrials");
                                                        
                                                        ?>
                                                        <?php $count = count($ct_codes); if ( $count > 0 ){ 
                                                            
                                                            foreach ( $ct_codes as $term ) {
                                                                $selected = '';
                                                                if($term->ID==$current_arr){
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
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="visit_overseas"></label>
                                                <div class="col-lg-6 col-sm-8">
                                                <?php

                                                    $checked = '';

                                                    if($visit->overseas == '1'){
                                                        $checked = ' checked';
                                                    }
                                                ?> 
                                                    <input name="visit_overseas" type="checkbox" id="visit_overseas" class="" style="width: 30px;float: left;" <?php echo $checked;?>>Includes Overseas Shipping
                                                </div>
                                            </div>





                                            <div class="form-group row">
                                                <?php echo $referer; ?>
                                                <button name="update-visit" type="submit" id="update-visit" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-visit" />
        
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