
<?php
if ( is_user_logged_in() ) {
       
	}else{ 
 
    wp_redirect( get_bloginfo('url') . '/fetch/aml_login.php' );
	exit();
    
 } ?>