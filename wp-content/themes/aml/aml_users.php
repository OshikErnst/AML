<?php 
/**
 * Template Name: Users Page
 *
 */
include('aml_checklogin.php');

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'del-user' ) {
	require_once(ABSPATH.'wp-admin/includes/user.php');
	wp_delete_user( $_POST['delid'] );
   
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

                                <h4 class="page-title">Users</h4>
                                <?php if ( $_GET['deleted'] == 'true' ) : ?> <div id="message" class="text-success"><p>user has been deleted.</p></div> <?php endif; ?>


                                <?php
                                $blogusers = get_users( 'blog_id=1&orderby=ID' );?>

                                
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $blogusers as $user ) {
                                        $user_info = get_userdata($user->ID)?>
                                    <tr>
                                        <th scope="row"><?php echo $user->ID;?></th>

                                        <td><a href=<?php echo home_url().'/user?userid='. esc_html( $user->ID ) ;?>><?php echo $user_info->first_name; ?> <?php echo $user_info->last_name; ?></a></td>
                                        <td>
                                            <?php if(current_user_can('administrator')){
                                            if(get_current_user_id() != $user->ID){
                                            ?>
                                            <form method="post" action="<?php the_permalink(); ?>">
                                            <p class="form-submit">
                                                
                                                <button name="del-user" type="submit" id="del-user" class="btn-xs btn-danger btn-delete" onclick="return ConfirmDelete();">Delete</button>
                                                
                                                <input name="action" type="hidden" value="del-user" />
                                                <input name="delid" type="hidden" value="<?php echo $user->ID;?>" />
                                            </p><!-- .form-submit -->
                                            </form>
                                            <?php } } ?>
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

