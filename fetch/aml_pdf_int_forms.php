<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );

require( dirname(__FILE__) . '/../wp-content/themes/aml/plugins/phpToPDF/phpToPDF.php');
//$formid = $_POST['formid'];
$formid = $_POST['formid'];
$ctcode = $_POST['ctcode'];
$shipment_date = $_POST['shipment_date'];
$manifest_name = $_POST['manifest_name'];

$pdf_file_name = $ctcode . '_' . $formid . '_' . $shipment_date;

update_post_meta( $formid, 'is_pdf', 'yes' );
update_post_meta( $formid, 'manifest_name', $manifest_name );
update_post_meta( $formid, 'pdf_file_name', $pdf_file_name );
// SET YOUR PDF OPTIONS
// FOR ALL AVAILABLE OPTIONS, VISIT HERE:  http://phptopdf.com/documentation/
$pdf_options = array(
  "source_type" => 'url',
  "source" => 'http://delivery.aml.co.il/fetch/aml_show_int_forms.php?formid='.$formid,
  "action" => 'save',
  "save_directory" => '../pdf',
  "file_name" => $pdf_file_name.'.pdf');

// CALL THE phptopdf FUNCTION WITH THE OPTIONS SET ABOVE
phptopdf($pdf_options);


?>

