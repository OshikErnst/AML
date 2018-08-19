<?php 
/**
 * Template Name: Visits Page
 *
 */
include('aml_checklogin.php');

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'del-visit' ) {
	global $wpdb;
	$wpdb->delete( 'aml_visits', array( 'ID' => $_POST['delid'] ) );
   
    wp_redirect( get_permalink().'/?deleted=true' ); exit;
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


                                <?php if ( $_GET['deleted'] == 'true' ) : ?> <div id="message" class="text-success"><p>visit has been deleted.</p></div> <?php endif; ?>


                                <?php
                                
                                global $wpdb;
                                $visits = $wpdb->get_results( "SELECT * FROM aml_visits");?>

                                


                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Visit ID</th>
                                        <th>Visit Name</th>
                                        <th>Clinical Trials</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $visits as $term ) {?>
                                    <tr>
                                        <th scope="row"><?php echo $term->ID;?></th>
                                        <td><a href=<?php echo home_url().'/visit/?visitid='. esc_html( $term->ID ) ;?>><?php echo $term->name; ?></a></td>
                                        <td>
                                            <?php 

                                                $visit = $wpdb->get_row( "SELECT * FROM aml_visits where ID=" . $term->ID);
                                                $current_ct = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=" . $term->clinical_trial);
                                                
                                                
                                                    echo $current_ct->name;  
                                                    echo '<br />';

                                                
                                                ?>

                                                
                                        </td>
                                        <td>
                                            <?php if(current_user_can('administrator')){
                                            
                                            ?>
                                            <form method="post" action="<?php the_permalink(); ?>">
                                                <p class="form-submit">
                                                    
                                                    
                                                    <button name="del-visit" type="submit" id="del-visit" class="btn-xs btn-danger btn-delete" onclick="return ConfirmDelete();">Delete</button>
                                                    <input name="action" type="hidden" value="del-visit" />
                                                    <input name="delid" type="hidden" value="<?php echo $term->ID;?>" />
                                                </p><!-- .form-submit -->
                                            </form>
                                            <?php } ?>
                                        </td>
                                        
                                    </tr>
                                        <?php }  ?>
                                    
                                    </tbody>
                                </table>
                                
                                        

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



<script type="text/javascript">
    function ConfirmDelete() {
      var result = confirm("Want to delete?");
      if (result) {
       return true;
      } else {
       return false;
      }
    }
</script>        
<?php get_footer();?>