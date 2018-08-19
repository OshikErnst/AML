<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );


$blogusers = get_users( 'blog_id=1&orderby=nicename' );
   		foreach ( $blogusers as $user ) {
            echo $user->ID;
            echo $user->display_name;
            echo '<br /><hr><br />';
        }
?>