<?php
/**
 * aml functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package aml
 */

add_filter('show_admin_bar', '__return_false');
add_filter( 'send_password_change_email', '__return_false' );

$object_type = 'post';
$args1 = array( // Validate and sanitize the meta value.
    // Note: currently (4.7) one of 'string', 'boolean', 'integer',
    // 'number' must be used as 'type'. The default is 'string'.
    'type'         => 'string',
    // Shown in the schema for the meta key.
    'description'  => 'A meta key associated with a string meta value.',
    // Return a single value of the type.
    'single'       => true,
    // Show in the WP REST API response. Default: false.
    'show_in_rest' => true,
);
register_meta( $object_type, 'ctcodes', $args1 );
register_meta( $object_type, 'visits', $args1 );
register_meta( $object_type, 'sites', $args1 );
register_meta( $object_type, 'targets', $args1 );
register_meta( $object_type, 'contact', $args1 );
register_meta( $object_type, 'phone', $args1 );
register_meta( $object_type, 'pickup', $args1 );
register_meta( $object_type, 'zone', $args1 );
register_meta( $object_type, 'courier', $args1 );
register_meta( $object_type, 'courier_email', $args1 );
register_meta( $object_type, 'taxi_hour', $args1 );
register_meta( $object_type, 'taxi_mins', $args1 );
register_meta( $object_type, 'hour_from', $args1 );
register_meta( $object_type, 'hour_to', $args1 );

register_meta( $object_type, 'date', $args1 );
register_meta( $object_type, 'notes', $args1 );

register_meta( $object_type, 'status', $args1 );

register_meta( $object_type, 'overseas', $args1 );


/*int forms*/

register_meta( $object_type, 'int_targets', $args1 );
register_meta( $object_type, 'awb', $args1 );
register_meta( $object_type, 'shipment_number', $args1 );
register_meta( $object_type, 'outbound_shipment_date', $args1 );
register_meta( $object_type, 'world_courier', $args1 );
register_meta( $object_type, 'shipping_type', $args1 );

register_meta( $object_type, 'is_pdf', $args1 );
register_meta( $object_type, 'pdf_file_name', $args1 );
register_meta( $object_type, 'manifest_name', $args1 );

register_meta( $object_type, 'table_notes', $args1 );