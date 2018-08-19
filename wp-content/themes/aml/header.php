<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package aml
 */
include('aml_checklogin.php');

if(is_front_page()){
    if(!current_user_can('administrator')){
        if(current_user_can('contributor')){
            wp_redirect( get_bloginfo('url') . '/int-forms' );
            exit();
        }
        else if( current_user_can( 'subscriber' ) ){   
            wp_redirect( get_bloginfo('url') . '/new-form' );
            exit();
        }
    }
}
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title(''); echo ' | ';  bloginfo( 'name' ); ?></title>

	<link href="<?php bloginfo('template_directory'); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php bloginfo('template_directory'); ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?php bloginfo('template_directory'); ?>/assets/css/style.css" rel="stylesheet" type="text/css" />

    <link href="<?php bloginfo('template_directory'); ?>/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php bloginfo('template_directory'); ?>/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link href="<?php bloginfo('template_directory'); ?>/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">

    


    <?php if(is_front_page() || is_page('int-forms') || is_page('local-forms')){?>

    	<!-- DataTables -->
        <link href="<?php bloginfo('template_directory'); ?>/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php bloginfo('template_directory'); ?>/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php bloginfo('template_directory'); ?>/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>

        <link href="<?php bloginfo('template_directory'); ?>/plugins/xeditable/bootstrap-editable.css" rel="stylesheet" type="text/css"/>

    <?php } ?>

    <script src="<?php bloginfo('template_directory'); ?>/assets/js/modernizr.min.js"></script>



	<?php wp_head(); ?>
	
</head>