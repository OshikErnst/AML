<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

global $wpdb;

$category = get_category('2');
$count = $category->category_count;

$loops = ceil($count/100);

$i = 1;
$service_url_all = [];


while ($i <= $loops) {


$service_url[$i] = get_bloginfo('url').'/wp-json/wp/v2/posts?categories=2&per_page=100&page='.$i;

	$curl = curl_init($service_url[$i]);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($curl);
	if ($curl_response === false) {
	    $info = curl_getinfo($curl);
	    curl_close($curl);
	    die('error occured during curl exec. Additioanl info: ' . var_export($info));
	}
	curl_close($curl);
	$cur_form = json_decode($curl_response);

	
foreach($cur_form as $term){
	$aForms["id"] = $term->id;

	$newDate = date("d-m-Y", strtotime($term->date));
    $aForms["date"] = $newDate;

    if($term->meta->ctcodes){
	    $ct_codes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=".$term->meta->ctcodes);
	    $aForms["int_ctcodes"] = $ct_codes->name;
	}

    if($term->meta->int_targets){
	    $int_targets = $wpdb->get_row( "SELECT * FROM aml_int_targets where ID=".$term->meta->int_targets);
	    $aForms["int_targets"] = $int_targets->name;
    }

	$aForms["awb"] = $term->meta->awb;

	$aForms["shipment_number"] = $term->meta->shipment_number;

	$aForms["outbound_shipment_date"] = $term->meta->outbound_shipment_date;

	if($term->meta->world_courier){
		$world_couriers = $wpdb->get_row( "SELECT * FROM aml_world_couriers where ID=".$term->meta->world_courier);
	    $aForms["world_courier"] = $world_couriers->name;
	}

    if($term->meta->shipping_type){
		$shipping_types = $wpdb->get_row( "SELECT * FROM aml_shipping_types where ID=".$term->meta->shipping_type);
	    $aForms["shipping_type"] = $shipping_types->name;   
	}

    
     
    $aForms["is_pdf"] = $term->meta->is_pdf;
    $aForms["pdf_file_name"] = $term->meta->pdf_file_name;
    
    $aForms["manifest_name"] = $term->meta->manifest_name;

    $aForms["table_notes"] = $term->meta->table_notes;

    if($term->meta->status != ''){
    	$aForms["int_status"] = $term->meta->status;
	}else{
		$aForms["int_status"] = '1';
	}

    $aFormsL[] = $aForms;
    //print_r($aFormsL);
}

	array_push($service_url_all, $aFormsL);
	$i++;    

}


echo json_encode($service_url_all[$loops-1]);

?>