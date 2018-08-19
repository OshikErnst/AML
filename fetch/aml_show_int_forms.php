<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );


?>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AML</title>

    <link href="<?php echo bloginfo('template_directory');?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo bloginfo('template_directory');?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo bloginfo('template_directory');?>/assets/css/style.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo bloginfo('template_directory');?>/assets/js/modernizr.min.js"></script>


<style>
	html,body{background: white;}
    h1{text-align: center;font-size:32px;}
    main{width: 500px;    margin: auto;}
	*{font-size:18px;}
    #wrapper{width:791px;margin:auto;}
	label{font-weight: bolder;}
	.content-page{margin-left: 0px!important;}
	.content-page > .content{margin-top: 0px!important;}
	fieldset{border:1px solid;}
</style>
</head>
<body class="fixed-left">

    <div id="wrapper">

                                    <?php
                                    global $post; 
                                    $post = get_post( $_GET['formid'] );
                                    setup_postdata( $post );
                                    $cur_ctcodes = get_post_meta( get_the_ID(), 'ctcodes', true );

                                    $cur_int_targets = get_post_meta( get_the_ID(), 'int_targets', true );
                                    $cur_awb = get_post_meta( get_the_ID(), 'awb', true );
                                    $cur_shipment_number = get_post_meta( get_the_ID(), 'shipment_number', true );
                                    $cur_outbound_shipment_date = get_post_meta( get_the_ID(), 'outbound_shipment_date', true );
                                    $cur_world_courier = get_post_meta( get_the_ID(), 'world_courier', true );
                                    $cur_shipping_type = get_post_meta( get_the_ID(), 'shipping_type', true );

                                    $cur_tube_number = get_post_meta( get_the_ID(), 'tube_number', true );
                                    $cur_tests = get_post_meta( get_the_ID(), 'tests', true );

                                    $cur_status = get_post_meta( get_the_ID(), 'status', true );

                                    ?>
                    


                                    <header>
                                        <img src="<?php echo bloginfo('template_directory');?>/assets/images/manifest_header.jpg" />
                                    </header>
                                    <h1>Shipping Manifest</h1>

                                    <main>
                                        <div class="form-group row">
                                            <label class="col-6" for="ctcodes">Clinical Trial</label>
                                            <div class="col-6">
                                                <?php 
                                                        $ct_codes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=" . $cur_ctcodes);
                                                        

                                                        echo $ct_codes->name;
                                                         ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-6" for="int_targets">Int Tagerts</label>
                                            <div class="col-6">
                                                
                                                          <?php 
                                                        $cur_int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where ID=" . $cur_int_targets);
                                                        

                                                        echo $cur_int_targets->name;
                                                         ?>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-6" for="awb">AWB</label>
                                            <div class="col-6">
                                                <?php echo $cur_awb; ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-6" for="shipment_number">Shipment Number</label>
                                            <div class="col-6">
                                                <?php echo $cur_shipment_number;?>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-6" for="outbound_shipment_date">Outbound Shipment Date </label>
                                            <div class="col-6">
                                                <?php echo $cur_outbound_shipment_date;?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-6" for="world_courier">Courier</label>
                                            <div class="col-6">
                                                  <?php 
                                                        $world_couriers = $wpdb->get_row( "SELECT * FROM aml_world_couriers where ID=" . $cur_world_courier);
                                                        

                                                        echo $world_couriers->name;
                                                         ?>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-6" for="shipping_type">Shipping Type</label>
                                            <div class="col-6">
                                                 <?php 
                                                        $shipping_types = $wpdb->get_row( "SELECT * FROM aml_shipping_types where ID=" . $cur_shipping_type);
                                                        

                                                        echo $shipping_types->name;
                                                         ?>
                                            </div>
                                        </div>

                                        <div id="tubes" class="col-lg-12 col-sm-12">
                                            <?php 
                                            
                                            if ( $cur_tube_number ){ 
                                            
                                            foreach ($cur_tube_number as $index => $value){
                                               

                                                ?>
                                            <div class="section form-group row">
                                                <fieldset class="col-lg-12 col-sm-12">
                                                    <div class="col-lg-6 col-xs-12 pull-left">
                                                        <label class="col-form-label" for="tube_number">Tube Number: </label>
                                                        <?php echo $cur_tube_number[$index];?>
                                                     </div>
                                                     <div class="col-lg-6 col-xs-12 pull-left">   
                                                        <label class="col-form-label" for="tests">Test: </label>
                                                        
                                                        <?php 
                                                        $cur_tests_query = $wpdb->get_row( "SELECT * FROM aml_tests where ID=" . $cur_tests[$index]);
                                                        

                                                        echo $cur_tests_query->name;
                                                         ?>
                                                    </div>
                       
                                                </fieldset>
                                            </div>
                                            <?php 
                                            
                                                } 

                                            }
                                           ?>
                                        </div>
                                </main>
                                    
                            

</div>
</body>



</html>