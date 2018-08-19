<?php 
/**
 * Template Name: Login Page
 *
 */
get_header(); ?>
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
<?php
get_footer();