<?php 
/**
 * Template Name: Forms Page
 *
 */
 include('aml_checklogin.php');

 
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

                                <h4 class="page-title">Forms</h4>

                                <?php if ( $_GET['deleted'] == 'true' ) : ?> <div id="message" class="text-success"><p>form has been deleted.</p></div> <?php endif; ?>

                                <?php if ( $_GET['sent'] == 'true' ) : ?> <div id="message" class="text-success"><p>form sent</p></div> <?php endif; ?>


                                <?php
                                $current_user = get_currentuserinfo();
                                $args = array('numberposts' => -1,'cat' => 1,'author' => $current_user->ID);
                                $allforms = new WP_Query($args);


                                ?>

                                


                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Form ID</th>
                                        <th>Form Name</th>
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    while ($allforms->have_posts()) {
                                    $allforms->the_post();?>
                                    <tr>
                                        <th scope="row"><?php echo get_the_ID();?></th>
                                        <td><a href=<?php echo home_url()?>/form?formid=<?php echo get_the_ID();?>><?php echo get_the_title(); ?></a></td>
                                        
                                        
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

     
<?php get_footer();?>