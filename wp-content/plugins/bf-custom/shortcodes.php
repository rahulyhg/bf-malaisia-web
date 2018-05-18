<?php
function bf_get_option($key, $default = ''){
    $val = get_field($key, 'option');
    return  $val?$val:$default;
}
function bf_check_token($token = 'token'){
    $errors = new WP_Error();
    if(isset( $_POST[$token] )) {
        if(wp_verify_nonce( $_POST[$token], $token )){
            return null;
        }
        $errors->add( 'token', __( 'The token is wrong','bf' ) );
        return $errors;
    }
    $errors->add( 'token', __( 'The token is null','bf' ) );
    return $errors; 
}
function bf_subscription_form($args) {
    ?>
    <form id="frm-subscription" method="post">
        <div>
            <?php echo get_field('subscription_desc','option');?>    
        </div>
        <div class="form-group row group-sub">
            <label for="sb-email" class="col-sm-3 col-form-label"><?php echo __('Email','bf');?></label>
            <div class="col-sm-9">
        		<input name="email" id="sb-email" class="input form-control" value="" size="20" type="email" required />
            </div>
        </div>
    	<div class="submit">
            <button name="wp-submit" id="wp-submit" class="button button-primary button-large" type="submit"><?php echo __('Submit','bf');?></button>
    	</div>
      <?php wp_nonce_field( 'token_newsletter', 'token_newsletter' );?>
    </form>
    <?php 
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('bf_subscription_form', 'bf_subscription_form');

function bf_login_form($args) {
    ?>
    <form name="loginform" id="loginform" method="post">
      <div class="bf-errors"></div>
        <div class="form-group row group-sub">
    		<label for="user_login" class="col-sm-4 col-form-label"><?php echo __('Phone number','bf');?></label>
            <div class="col-sm-8">
    		    <input name="log" id="user_login" class="input form-control" value="" size="20" type="text" required />
            </div>
        </div>
        <div class="form-group row group-sub">
    		<label for="user_pass" class="col-sm-4 col-form-label"><?php echo __('Password','bf');?></label>
            <div class="col-sm-8">
    		    <input name="pwd" id="user_pass" class="input form-control" value="" size="20" type="password" required />
            </div>
        </div>
    		<p class="forgetpass"><a href="javascript:;" class="bf-forgetpass" data-info="<?php echo bf_get_option('forget_pass_message', __('Please call us at 1900.6440 to reset your password','bf'));?>"><?php echo __('Forgot your password?','bf');?></a></p>
    	<div class="submit">
    		<input name="wp-submit" class="button button-primary button-large btn-login" value="<?php echo __('LogIn','bf');?>" type="submit">
    	</div>
    	<p>
    	<?php 
    	echo sprintf( __( 'You have not register your information to be able to win our prize? <a class="sign-up" href="%1$s">Sign up now</a>','bf' ),	home_url('/sign-up') );
    	?>
    	</p>
    	<?php wp_nonce_field( 'token_login', 'token_login' );?>
    </form>
    <?php 
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('bf_login_form', 'bf_login_form');

function bf_signup_form($args) {
    ?>
    <form name="registerform" id="registerform" method="post" data-redirect-game="<?php echo site_url('game'); ?>" data-redirect="<?php echo site_url('products'); ?>">
        <div class="bf-errors"></div>
        <div class="form-group row group-sub">
            <label for="first_name" class="col-sm-4 col-form-label"><?php echo __('First Name', 'bf'); ?>*</label>
            <div class="col-sm-8">
                <input name="first_name" id="first_name" class="form-control input" value="" type="text" data-required="" data-format="" data-validate=""/>
                <p class="invalid-messages"></p>
            </div>
        </div>
        <div class="form-group row group-sub">
            <label for="last_name" class="col-sm-4 col-form-label"><?php echo __('Last Name', 'bf'); ?>*</label>
            <div class="col-sm-8">
                <input name="last_name" id="last_name" class="input form-control" value="" type="text" data-required="" data-format="" data-validate=""/>
                <p class="invalid-messages"></p>
            </div>
        </div>
        <div class="form-group row group-sub">
            <label for="user_dob" class="col-sm-4 col-form-label"><?php echo __('Date of Birth', 'bf'); ?>*</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="user_dob" id="user_dob" placeholder="DD/MM/YYYY" value="" data-validate="date" data-required="" data-format=""/>
                <p class="invalid-messages"></p>
            </div>
        </div>
        <div class="form-group row group-sub">
            <label for="user_phone" class="col-sm-4 col-form-label"><?php echo __('Phone number', 'bf'); ?>*</label>
            <div class="col-sm-8">
                <input name="user_phone" id="user_phone" class="input form-control" value="" type="text" data-validate="phone" data-required="" data-format=""/>
                <p class="invalid-messages"></p>
            </div>
        </div>
        <div class="form-group row group-sub">
            <label for="user_email" class="col-sm-4 col-form-label"><?php echo __('Email', 'bf'); ?></label>
            <div class="col-sm-8">
                <input name="user_email" id="user_email" class="input form-control" value="" type="text" data-validate="email" data-required="" data-format=""/>
                <p class="invalid-messages"></p>
            </div>

        </div>
        <div class="form-group row group-sub">
            <label for="user_pass" class="col-sm-4 col-form-label"><?php echo __('Password', 'bf'); ?>*</label>
            <div class="col-sm-8">
                <input name="user_pwd" id="user_pwd" class="input form-control" value="" size="25" type="password" data-required="" data-format="" data-validate="password"/>
                <p class="invalid-messages"></p>
            </div>
        </div>
        <div class="form-check group-sub">
            <label for="terms_condition" class="form-check-label signup-disclaimer">
<!--                <input class="form-check-input" type="checkbox" name="terms_condition" id="terms_condition" data-required="" data-validate="checkbox"/>-->
                <?php echo __('By click CONFIRM button, I agree to let Company collect, use and transfer my information to third parties under Vietnamese Law.', 'bf'); ?>
<!--                <p class="invalid-messages"></p>
                <span class="checkmark clearfix"></span>-->
            </label>
        </div>
        <div class="submit">
            <input name="wp-submit" class="button button-primary button-large btn-signup"
                   value="<?php echo __('Confirm', 'bf'); ?>" type="submit">
        </div>
        <?php wp_nonce_field('token_signup', 'token_signup'); ?>
    </form>
    <?php 
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('bf_signup_form', 'bf_signup_form');