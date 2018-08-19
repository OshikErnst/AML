<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

global $wpdb;

$category = get_category('1');
$count = $category->category_count;

$loops = ceil($count/100);

$i = 1;
$service_url_all = [];

while ($i <= $loops) {
    
	$service_url[$i] = get_bloginfo('url').'/wp-json/wp/v2/posts?categories=1&per_page=100&page='.$i;
	
	$curl = curl_init($service_url[$i]);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	$cur_form = json_decode($curl_response);
	
	foreach($cur_form as $term){


	$aForms["id"] = $term->id;

	$newDate = date("d-m-Y", strtotime($term->date));
    $aForms["date"] = $newDate;

    $ct_codes = $wpdb->get_row( "SELECT * FROM aml_clinicaltrials where ID=".$term->meta->ctcodes);
    $aForms["ctcodes"] = $ct_codes->name;

    $cur_visits = unserialize($term->meta->visits);

    if($cur_visits){
    	$all_cur_visits = '';
	    foreach ( $cur_visits as $visit_term ) {
		    $cur_visit = $wpdb->get_row( "SELECT * FROM aml_visits where ID=" .$visit_term);
            $cur_name = $cur_visit->name;
            if($cur_visit->overseas){
                $cur_name = $cur_name . ' ~';
            }
	    	$all_cur_visits .= $cur_name.'<br /> ';

	    }

	}
    

    
    $all_cur_visits =  substr($all_cur_visits, 0, -7);
    $aForms["visits"] = $all_cur_visits;

    $ct_sites = $wpdb->get_row( "SELECT * FROM aml_sites where ID=".$term->meta->sites);
    $aForms["sites"] = $ct_sites->name . " &#45; " . $ct_sites->department;    

    $ct_targets = $wpdb->get_row( "SELECT * FROM aml_targets where ID=".$term->meta->targets);
    $aForms["targets"] = $ct_targets->name;       

    $ct_couriers = $wpdb->get_row( "SELECT * FROM aml_couriers where ID=".$term->meta->courier);
    $aForms["couriers"] = $ct_couriers->name;    

    $ct_pickups = $wpdb->get_row( "SELECT * FROM aml_pickup_types where ID=".$term->meta->pickup);
    $aForms["pickup"] = $ct_pickups->name;           

	$aForms["pickup_date"] = $term->meta->date;

	if($term->meta->taxi_hour){
        $aForms["pickup_time"] = $term->meta->taxi_hour .':'. $term->meta->taxi_mins;
    }else{
        $aForms["pickup_time"] = $term->meta->hour_from .'-'. $term->meta->hour_to;
    }

    
    if($term->meta->status != ''){
        $aForms["status"] = $term->meta->status;
    }else{
        $aForms["status"] = '1';
    }

    $aFormsL[] = $aForms;
    //print_r($aFormsL);
}

	array_push($service_url_all, $aFormsL);
	$i++;    

}


echo json_encode($service_url_all[$loops-1]);

?>