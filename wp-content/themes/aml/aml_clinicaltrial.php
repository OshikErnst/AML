<?php 
/**
 * Template Name: Clinical Trial
 *
 */
 include('aml_checklogin.php');
 
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-ct_code' ) {

   
	$wpdb->update( 
	'aml_clinicaltrials', 
	array( 
		'name' => $_POST['ct_name'],
		'description' => $_POST['ct_description']
	), 
	array( 'ID' => $_POST['ct_code_id'] ), 
	array( 
		'%s',
		'%s'
	), 
	array( '%d' )
    );


    $ct_sites = $_POST['ct_sites'];
    $int_targets = $_POST['int_targets'];
    $tests = $_POST['tests'];

    $wpdb->delete( 'aml_ct_sites', array( 'ct_id' => $_POST['ct_code_id'] ) );
    $wpdb->delete( 'aml_ct_tests', array( 'ct_id' => $_POST['ct_code_id'] ) );
    $wpdb->delete( 'aml_ct_int_targets', array( 'ct_id' => $_POST['ct_code_id'] ) );

    foreach ( $ct_sites as $term ) {
        $wpdb->insert( 
            'aml_ct_sites', 
            array( 
                'ct_id' => $_POST['ct_code_id'],
                'site_id' => $term  
            ), 
            array( 
                '%d',   
                '%d'
            ) 
        );
        

    }


    foreach ( $int_targets as $term ) {
        $wpdb->insert( 
            'aml_ct_int_targets', 
            array( 
                'ct_id' => $_POST['ct_code_id'],
                'int_target' => $term  
            ), 
            array( 
                '%d',   
                '%d'
            ) 
        );
        

    }


    foreach ( $tests as $term ) {
        $wpdb->insert( 
            'aml_ct_tests', 
            array( 
                'ct_id' => $_POST['ct_code_id'],
                'test_id' => $term  
            ), 
            array( 
                '%d',   
                '%d'
            ) 
        );
        

    }


	wp_redirect( get_permalink().'/?ctid='.$_POST['ct_code_id'].'&updated=true' ); exit;

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

                                <h4 class="page-title">Clinical Trials</h4>
                                

                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry">

                                     
                                        <?php if ( $_GET['updated'] == 'true' ) : ?> <div id="message" class="text-success"><p>clinical trial has been updated.</p></div> <?php endif; ?>

                                        <?php 
                                        global $wpdb;
										$ct_codes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=" . $_REQUEST['ctid']);?>
		

                                        <div class="p-20">

                                        <form method="post" id="updatect_code" action="<?php the_permalink(); ?>?ctid=<?php echo $_REQUEST['ctid'];?>">

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="ct_codes_id">ID</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="ct_code_id" type="hidden" id="ct_code_id" class="form-control" value="<?php echo $ct_codes->ID; ?>">
                                                    <?php echo $ct_codes->ID; ?>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="ct_name">Clinical Trial Name</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <input name="ct_name" type="text" id="ct_name" class="form-control" value="<?php echo $ct_codes->name; ?>" />
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="ct_description">Clinical Trial Description</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                    <textarea class="form-control" name="ct_description" type="text" id="ct_description"><?php echo $ct_codes->description; ?></textarea>
                                                </div>
                                            </div>


                                            <?php 

                                                $current_arr = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=" . $ct_codes->ID);

                                                $current_sites = $wpdb->get_results( "SELECT site_id FROM aml_ct_sites where ct_id=" . $ct_codes->ID);
                                                $current_int_targets = $wpdb->get_results( "SELECT int_target FROM aml_ct_int_targets where ct_id=" . $ct_codes->ID);
                                                $current_tests = $wpdb->get_results( "SELECT test_id FROM aml_ct_tests where ct_id=" . $ct_codes->ID);


                                                
                                                
                                                
                                            ?>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="sites">Sites</label>
                                                <div class="col-lg-4 col-sm-8"> 
                                                
										        <select  name="ct_sites[]" multiple="multiple" class="form-control  select2 select2-multiple" data-placeholder="Choose ...">
										            
										            <?php
										            global $wpdb;
										            $sites = $wpdb->get_results( "SELECT * FROM aml_sites");
										            
										            ?>
										            <?php $count = count($sites); if ( $count > 0 ){ 
										                
										                foreach ( $sites as $term ) {

										                    $selected = '';
                                                            foreach($current_sites as $obj)
                                                            {
                                                                if ($obj->site_id == $term->ID)
                                                                {
                                                                    $selected = " selected";
                                                                    break;
                                                                }
                                                            }

										                ?>
										                <option value="<?php echo $term->ID;?>" <?php echo $selected;?>><?php echo $term->name; ?> - <?php echo $term->department; ?></option>
										                
										            <?php } 
										            } ?>
										        </select>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="int_tagerts">Int Targets</label>
                                                <div class="col-lg-4 col-sm-8"> 

                                                                        
                                                <select name="int_targets[]" multiple="multiple" class="form-control  select2 select2-multiple" data-placeholder="Choose ...">
                                                    
                                                    <?php
                                                    global $wpdb;
                                                    $int_targets = $wpdb->get_results( "SELECT * FROM aml_int_targets");
                                                    
                                                    ?>
                                                    <?php $count = count($int_targets); if ( $count > 0 ){ 
                                                        
                                                        foreach ( $int_targets as $term ) {

                                                            $selected = '';
                                                            foreach($current_int_targets as $obj)
                                                            {
                                                                if ($obj->int_target == $term->ID)
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
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="tests">Tube Names</label>
                                                <div class="col-lg-4 col-sm-8"> 

                                                                        
                                                <select name="tests[]" multiple="multiple" class="form-control  select2 select2-multiple" data-placeholder="Choose ...">
                                                    
                                                    <?php
                                                    global $wpdb;
                                                    $tests = $wpdb->get_results( "SELECT * FROM aml_tests");
                                                    
                                                    ?>
                                                    <?php $count = count($tests); if ( $count > 0 ){ 
                                                        
                                                        foreach ( $tests as $term ) {
                                                            $selected = '';
                                                            foreach($current_tests as $obj)
                                                            {
                                                                if ($obj->test_id == $term->ID)
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
                                                <button name="update-ct_code" type="submit" id="update-ct_code" class="btn btn-default"><?php _e('Update', 'profile'); ?></button>

                                                <button name="cancel-form" type="button" id="cancel-form" class="btn"><?php _e('Cancel', 'profile'); ?></button>
                                                
                                                <input name="action" type="hidden" id="action" value="update-ct_code" />
        
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