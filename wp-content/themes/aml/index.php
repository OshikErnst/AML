<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package aml
 */

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
                                <h4 class="text-left">Local Forms</h4>
                                <table id="forms_table"  class="table table-hover table-bordered responsive no-wrap" cellspacing="0" >
                                        <thead>
                                        <tr>
                                            <th>תאריך</th>
                                            <th>מספר משלוח</th>
                                            <th>שם המחקר</th>
                                            <th>שם הביקור</th>
                                            <th>שם האתר</th>
                                            <th>יעד המשלוח</th>
                                            <th>חברת משלוח</th>
                                            <th>סוג שליחות</th>
                                            <th>תאריך איסוף</th>
                                            <th>שעת איסוף</th>
                                            <th>סטטוס</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                       

                                        <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        
                                        </tfoot>


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
