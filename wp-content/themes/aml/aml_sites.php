<?php 
/**
 * Template Name: Sites Page
 *
 */
include('aml_checklogin.php');
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'del-site' ) {
	global $wpdb;
	$wpdb->delete( 'aml_sites', array( 'ID' => $_POST['delid'] ) );
    $wpdb->delete( 'aml_ct_int_sites', array( 'site_id' => $_POST['delid'] ) );
   
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

                                <h4 class="page-title">Sites</h4>


                                <?php if ( $_GET['deleted'] == 'true' ) : ?> <div id="message" class="text-success"><p>site has been deleted.</p></div> <?php endif; ?>


                                <?php
                                
                                global $wpdb;
                                $sites = $wpdb->get_results( "SELECT * FROM aml_sites");?>

                                


                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Site ID</th>
                                        <th>Site Name</th>
                                        <th>Clinical Trials</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $sites as $term ) {?>
                                    <tr>
                                        <th scope="row"><?php echo $term->ID;?></th>
                                        <td><a href=<?php echo home_url().'/site/?siteid='. esc_html( $term->ID ) ;?>><?php echo $term->name; ?> - <?php echo $term->department; ?></a></td>


                                        <td>
                                            <?php 

                                                $current_ct = $wpdb->get_results( "SELECT * FROM aml_ct_sites where site_id=" . $term->ID);

                                                
                                                foreach ( $current_ct as $term ) {

                                                    $sites = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=" . $term->ct_id);

                                                    echo $sites->name;  
                                                    echo '<br />';

                                                }
                                                ?>

                                                
                                        </td>





                                        <td>
                                            <?php if(current_user_can('administrator')){
                                            
                                            ?>
                                            <form method="post" action="<?php the_permalink(); ?>">
                                                <p class="form-submit">
                                                    
                                                    
                                                    <button name="del-site" type="submit" id="del-site" class="btn-xs btn-danger btn-delete" onclick="return ConfirmDelete();">Delete</button>
                                                    <input name="action" type="hidden" value="del-site" />
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