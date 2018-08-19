<?php
require_once( dirname(__FILE__) . '../../wp-load.php' );?>
<!doctype html>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>  Login | AML</title>

	<link href="<?php echo bloginfo('template_directory')?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo bloginfo('template_directory')?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo bloginfo('template_directory')?>/assets/css/style.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo bloginfo('template_directory')?>/assets/js/modernizr.min.js"></script>

	
</head>

<div class="wrapper-page">
    <div class="card-box">
        <div class="panel-heading">
            <h4 class="text-center"> Sign In to <strong>AML</strong></h4>
        </div>


        <div class="p-20">
            <?php 
            global $user_login;
            // In case of a login error.
            if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
                    <div class="aa_error">
                        <p><?php _e( 'FAILED: Try again!', 'AA' ); ?></p>
                    </div>
            <?php 
                endif;
            // If user is already logged in.
            
                
                    // Login form arguments.
                    $args = array(
                        'echo'           => true,
                        'redirect'       => home_url(), 
                        'form_id'        => 'loginform',
                        'label_username' => __( 'Username' ),
                        'label_password' => __( 'Password' ),
                        'label_remember' => __( 'Remember Me' ),
                        'label_log_in'   => __( 'Log In' ),
                        'id_username'    => 'user_login',
                        'id_password'    => 'user_pass',
                        'id_remember'    => 'rememberme',
                        'id_submit'      => 'wp-submit',
                        'remember'       => true,
                        'value_username' => NULL,
                        'value_remember' => true
                    ); 
                    
                    // Calling the login form.
                    wp_login_form( $args );
              
            ?> 

        </div>
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>	
  <script>
	    var resizefunc = [];
	</script>

	<!-- jQuery  -->

	<script src="<?php echo bloginfo('template_directory')?>/assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
	<script src="<?php echo bloginfo('template_directory')?>/assets/js/bootstrap.min.js"></script>
	
        

    </body>
</html>