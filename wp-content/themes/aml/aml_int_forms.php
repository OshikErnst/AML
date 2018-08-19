<?php 
/**
 * Template Name: Int Forms Page
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
                                <h4 class="text-left">International Forms</h4>
                                <table id="int_forms_table"  class="table table-hover table-bordered responsive no-wrap" cellspacing="0" >
                                        <thead>
                                        <tr>
                                            <th>תאריך</th>
                                            <th>מספר משלוח פנימי</th>
                                            <th>שם המחקר</th>
                                            <th>יעד המשלוח</th>
                                            <th>awb</th>
                                            <th>מספר משלוח</th>
                                            <th>תאריך משלוח</th>
                                            <th>חברת שליחות</th>
                                            <th>סוג שליחות</th>
                                            <th>יוצר מניפסט</th>
                                            <th>קובץ מניפסט</th>
                                            <th>הערות</th>
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