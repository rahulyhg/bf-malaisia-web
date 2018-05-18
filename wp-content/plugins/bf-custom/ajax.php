<?php
function bf_ajax_login(){
    $errors = new WP_Error();
    $secure_cookie = '';
    // If the user wants ssl but the session is not ssl, force a secure cookie.
    if ( !empty($_POST['log']) && !force_ssl_admin() ) {
        $user_name = sanitize_user($_POST['log']);
        $user = get_user_by( 'login', $user_name );
        /* if ( ! $user  ) {
            $user = get_user_by( 'email', $user_name );
        } */
        if ( ! $user  ) {
            $errors->add( 'user_phone', __( 'Your phone number is not exists!','bf' ) );
            wp_send_json_error($errors);
        }
        if ( $user ) {
            if ( get_user_option('use_ssl', $user->ID) ) {
                $secure_cookie = true;
                force_ssl_admin(true);
            }
        }
    }
    $user = wp_signon( array(), $secure_cookie );
    if ( empty( $_COOKIE[ LOGGED_IN_COOKIE ] ) ) {
        if ( headers_sent() ) {
            /* translators: 1: Browser cookie documentation URL, 2: Support forums URL */
            $user = new WP_Error( 'test_cookie', sprintf( __( 'Cookies are blocked due to unexpected output. For help, please see <a href="%1$s">this documentation</a> or try the <a href="%2$s">support forums</a>.' ),
                    __( 'https://codex.wordpress.org/Cookies' ), __( 'https://wordpress.org/support/' ) ) );
        }
    }
    if ( !is_wp_error($user) ) {
        $data = array('action' => 'reload','title' => __('Congratulation!','bf-register'),'content'=>__('You have logged in successfully.','bf-register'));
        wp_send_json_success($data);
    }else{
        if(!empty($user->errors['invalid_username'])){
            $user->errors['invalid_username'][0] = __('Your phone number is not exists!');
        }
        if(!empty($user->errors['invalid_email'])){
            $user->errors['invalid_email'][0] = __('Your email is not exists!');
        }
        if(!empty($user->errors['incorrect_password'])){
            $user->errors['incorrect_password'][0] = __('The password is incorrect');
        }
        wp_send_json_error($user);
    }
}
add_action('wp_ajax_nopriv_bf_login', 'bf_ajax_login');

function bf_ajax_signup(){
    $errors = bf_check_token('token_signup');
    if(is_wp_error($errors)){
        wp_send_json_error($errors);
    }
    $user_login = '';
    $user_email = '';
    $user_pass = '';
     
    if ( isset( $_POST['user_email'] ) && is_string( $_POST['user_email'] ) ) {
        $user_email = wp_unslash( $_POST['user_email'] );
    }
    
    if ( isset( $_POST['user_pwd'] ) && is_string( $_POST['user_pwd'] ) ) {
        $user_pass =  $_POST['user_pwd'];
    }
    
    if ( isset( $_POST['user_phone'] ) && is_string( $_POST['user_phone'] ) ) {
        $user_login = $_POST['user_phone'];
    }
    
    $errors = new WP_Error();
    
    $user_email = apply_filters( 'user_registration_email', $user_email );
    
    // Check the email address
    /* if ( $user_email == '' ) {
        $errors->add( 'empty_email', __( 'Please type your email address.' ) );
    } elseif ( ! is_email( $user_email ) ) {
        $errors->add( 'invalid_email', __( 'The email address isn&#8217;t correct.' ) );
        $user_email = '';
    } else */
    if ($user_login == ''){
        $errors->add( 'user_phone', __( 'Enter your phone number','bf' ) );
    } elseif ( username_exists( $user_login ) ) {
        $errors->add( 'phone_exists', __( 'This phone is already registered, please choose another one.' ) );
    } elseif ( $user_email != '' && email_exists( $user_email ) ) {
        $errors->add( 'email_exists', __( 'This email is already registered, please choose another one.' ) );
    } elseif ($user_pass == ''){
        $errors->add( 'user_pass', __( 'Please enter a password.' ) );
    }
    
    $sanitized_user_login = sanitize_user( $user_login );
    
    do_action( 'register_post', $sanitized_user_login, $user_email, $errors );
    
    $errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
    
    if ( $errors->get_error_code() )
        wp_send_json_error($errors);
    
    $user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
    if ( ! $user_id || is_wp_error( $user_id ) ) {
        $errors->add( 'registerfail', sprintf( __( 'Couldn&#8217;t register you&hellip; please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
        wp_send_json_error($errors);
    }
    
    update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
    update_user_meta( $user_id, 'billing_first_name', $_POST['first_name'] );
    update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
    update_user_meta( $user_id, 'billing_last_name', $_POST['last_name'] );
    update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] );
    update_user_meta( $user_id, 'billing_phone', $_POST['user_phone'] );
    update_user_meta( $user_id, 'user_dob', $_POST['user_dob'] );
    
    if ( ! empty($_POST['log']) )
        $credentials['user_login'] = $_POST['log'];
    if ( ! empty($_POST['pwd']) )
        $credentials['user_password'] = $_POST['pwd'];
    
    $user = wp_signon( array('user_login' => $user_login,'user_password' => $user_pass) );
    
    $data = array('action' => 'reload', 'title' => bf_get_option('signup_success_title', __('Congratulation!','bf')),'content'=>bf_get_option('signup_success_message',  __('You have registered! <br />Order to win the prizes!','bf')));
    wp_send_json_success($data);
}
add_action('wp_ajax_nopriv_bf_signup', 'bf_ajax_signup');

function bf_ajax_newsletter(){
    
    $errors = bf_check_token('token_newsletter');
    if(is_wp_error($errors)){
        wp_send_json_error($errors);
    }
    $email = '';
    if ( isset( $_POST['email'] ) && is_string( $_POST['email'] ) ) {
        $email = wp_unslash( $_POST['email'] );
    }
    $errors = new WP_Error();
    
    if ( ! is_email( $email ) ) {
        $errors->add( 'invalid_email', __( 'The email address isn&#8217;t correct.','bf' ) );
        wp_send_json_error($errors);
    }else{
        global $wpdb;
        $table = $wpdb->prefix . "newsletter";
        $fields = array(
            'email'=> $email,
            'created' => date('Y-m-d H:i:s'),
        );
        $wpdb->insert( $table, $fields);
        $data = array('title' => get_field('subscription_success_title', 'option'),'content'=>get_field('subscription_success_message', 'option'));
        wp_send_json_success($data);
    }   
}
add_action('wp_ajax_nopriv_bf_ajax_newsletter', 'bf_ajax_newsletter');
add_action('wp_ajax_bf_ajax_newsletter', 'bf_ajax_newsletter');