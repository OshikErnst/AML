<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

global $post; 
$post = get_post( $_POST['formid'] );
setup_postdata( $post );

$cur_ctcodes = get_post_meta( get_the_ID(), 'ctcodes', true );
$fetch_ct_code = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $cur_ctcodes);

$cur_sites = get_post_meta( get_the_ID(), 'sites', true );
$fetch_sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID = " . $cur_sites);

$int_ctcodes = get_post_meta( get_the_ID(), 'ctcodes', true );
$fetch_int_ctcodes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID = " . $int_ctcodes);

$int_targets = get_post_meta( get_the_ID(), 'int_targets', true );
$fetch_int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where ID = " . $int_targets);

    
    


$data_all = [];

$all_data['cur_ctcodes'] = $fetch_ct_code->name;
$all_data['cur_sites'] = $fetch_sites->name . " - " . $fetch_sites->department;  ;

$all_data['int_ctcodes'] = $fetch_int_ctcodes->name;
$all_data['int_targets'] = $fetch_int_targets->name;

array_push($data_all, $all_data);

echo json_encode($data_all[0]);

?>