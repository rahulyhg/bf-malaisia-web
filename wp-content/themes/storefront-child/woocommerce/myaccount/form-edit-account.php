    <?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

if (!isset($hide_header_on_edit_account_form)) {
  include "_my-account-header.php";
}
else {
  // Show edit account form in the same page with order list.
  $user = get_user_by( 'id', get_current_user_id() );
}

global $woocommerce;

// $term_check = $user->terms_condition ? 'checked': '';
/* $billing_fields = [
  'billing_gender'  => ['label' => __( 'Gender', 'myaccount' ),
    'type' => 'radio', 'options' => ['male' => __('Male', 'myaccount'), 'female' => __('Female', 'myaccount')],
    'required' => true],
  'billing_company'  => ['label' => __( 'Company', 'myaccount' ), 'required' => false],
  'billing_address_1'  => ['label' => __( 'Address 1', 'myaccount' ), 'required' => true],
  'billing_city'  => ['label' => __( 'City', 'myaccount' ), 'required' => true],
  'billing_postcode'  => ['label' => __( 'Post code', 'myaccount' ), 'required' => false]
]; */

$load_address = 'billing';
$current_user = wp_get_current_user();

$billing_fields = WC()->countries->get_address_fields( get_user_meta( get_current_user_id(), $load_address . '_country', true ), $load_address . '_' );


/* $billing_adress = $user->billing_first_name . ' ' . $user->billing_last_name .', '  ;
$billing_adress .= $user->billing_phone . ', ' ;
$billing_adress .= $user->billing_company . ', ' ;
$billing_adress .= $user->billing_address_1 . ', ' . $user->billing_city . ', ';
$billing_adress .= $user->billing_postcode . ', ' . $user->billing_country; */

$billing_adress = str_replace("<br/>", ', ', wc_get_account_formatted_address( 'billing' )) ;
/* $shipping_fields = [
  'shipping_first_name'  => ['label' => __( 'First name', 'myaccount' ), 'required' => true],
  'shipping_last_name'  => ['label' => __( 'Last name', 'myaccount' ), 'required' => true],
  'shipping_company'  => ['label' => __( 'Company', 'myaccount' ), 'required' => false],
  'shipping_address_1'  => ['label' => __( 'Address 1', 'myaccount' ), 'required' => true],
  'shipping_city'  => ['label' => __( 'City', 'myaccount' ), 'required' => true],
  'shipping_postcode'  => ['label' => __( 'Post code', 'myaccount' ), 'required' => false],
]; */

$load_address = 'shipping';
$shipping_fields = WC()->countries->get_address_fields( get_user_meta( get_current_user_id(), $load_address . '_country', true ), $load_address . '_' );


/* $shipping_adress = $user->shipping_first_name . ' ' . $user->shipping_last_name . ', ';
$shipping_adress .= $user->shipping_company . ', ';
$shipping_adress .= $user->shipping_address_1 . ', ' . $user->shipping_city . ', ';
$shipping_adress .= $user->shipping_postcode . ', ' . $user->shipping_country; */

$shipping_adress = str_replace("<br/>", ', ', wc_get_account_formatted_address( 'shipping' )) ;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="edit-account" action="" method="post">
  <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
  <div class="form-group row first-name">
    <label class="title-name" for="account_first_name"><?php esc_html_e( 'First name', 'myaccount' ); ?> <span class="required"></span></label>
    <div class="edit-text">
        <div class="hidden-input"></div>
        <u>
            <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
            <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
        </u>
      <input type="text" class="form-control input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?> "/>
    </div>
  </div>
  <div class="form-group row last-name">
    <label class="title-name" for="account_last_name"><?php esc_html_e( 'Last name', 'myaccount' ); ?> <span class="required"></span></label>
    <div class="edit-text">
        <div class="hidden-input"></div>
        <u>
            <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
            <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
        </u>
      <input type="text" class="form-control input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>"/>
    </div>
  </div>
  <div class="form-group row dob">
    <label class="title-name" for="user_dob"><?php esc_html_e( 'Date of birth', 'myaccount' ); ?> <span class="required"></span></label>
    <div class="edit-text">
        <div class="hidden-input"></div>
        <u>
            <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
            <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
        </u>
      <input type="text" class="form-control input-text" name="user_dob" id="user_dob" value="<?php echo esc_attr( $user->user_dob ); ?>"/>
    </div>
  </div>
  <div class="form-group row phone">
    <label class="title-name" for="user_phone"><?php esc_html_e( 'Phone number', 'myaccount' ); ?> <span class="required"></span></label>
    <div class="edit-text">
        <div class="hidden-input"></div>
        <u>
            <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
            <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
        </u>
      <input type="text" class="form-control input-text" name="user_phone" id="user_phone" value="<?php echo esc_attr( $user->user_phone ); ?>"/>
    </div>
  </div>
  <div class="form-group row email">
    <label class="title-name" for="account_email"><?php esc_html_e( 'Email', 'woocommerce' ); ?> <span class="required"></span></label>
    <div class="edit-text">
        <div class="hidden-input"></div>
        <u>
            <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
            <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
        </u>
      <input type="email" class="form-control input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>"/>
    </div>
  </div>
  <div class="form-group row current-pwd">
    <label class="title-name" for="password_current"><?php esc_html_e( 'password', 'myaccount' ); ?></label>
    <div class="edit-text">
        <div class="hidden-input"></div>
        <u class="password">
            <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
            <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
        </u>
      <input type="password" class="form-control input-text" name="password_current" id="password_current"/>
    </div>
  </div>
    <div class="edit-pw">
        <div class="form-group row new-pwd">
            <label class="title-name" for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'myaccount' ); ?></label>
            <div class="edit-text">
                <input type="password" class="form-control input-text" name="password_1" id="password_1" />
            </div>
        </div>
        <div class="form-group row confirm-pwd">
            <label class="title-name" for="password_2"><?php esc_html_e( 'Confirm new password', 'myaccount' ); ?></label>
            <div class="edit-text">
                <input type="password" class="form-control input-text" name="password_2" id="password_2" />
            </div>
        </div>
    </div>
  <div class="billing-address">
      <div class="form-group row info">
        <label class="title-name"><?php esc_html_e( 'address', 'myaccount' ); ?></label>
          <div class="edit-text">
              <div class="hidden-input"></div>
              <u class="billing-address-click">
                  <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
                  <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
              </u>
              <input type="text" class="form-control input-text" value="<?php echo $billing_adress; ?>"/>
          </div>
        <!--<div class="col-sm-8 txt"><?php /*echo $billing_adress; */?></div>-->
      </div>
        <div class="billing-address-detail">
            <?php
            unset($billing_fields['billing_first_name']);
            unset($billing_fields['billing_last_name']);
            unset($billing_fields['billing_phone']);
            unset($billing_fields['billing_country']);
            unset($billing_fields['billing_email']);
            foreach ($billing_fields as $field_name => $option): 
            $value = $user->{$field_name};
            ?>
                <div class="form-group row <?php echo $field_name ?>">
                    
                    <label class="title-name" for="<?php echo $field_name ?>"><?php echo $option['label']; ?> <?php if ($option['required']): ?><span class="required"></span><?php endif; ?></label>
                    <div class="edit-text row">
                      <?php 
                      
                      
                         if ($field_name === 'billing_gender'): 
                           foreach ($option['options'] as $key => $label): ?>
                          <?php $checked = ($user->{$field_name} === $key) ? 'checked="checked"': ''; ?>
                          <label class="col-sm-4">
                            <input type="radio" name="<?php echo $field_name ?>" value="<?php echo $key ?>" <?php echo $checked; ?>>
                            <?php echo $label; ?>
                          </label>
                        <?php endforeach;
                        else:
                        if(empty($option['type'])){
                            ?>
                            <input type="text" class="form-control input-text" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>" value="<?php echo esc_attr( $user->{$field_name} ); ?>" />
                            <?php 
                        }
                        else{
                            switch ($option['type']){//country
                                case 'select':
                                    $field   = '';
                                    $options = '';
                                    if ( ! empty( $option['options'] ) ) {
                                        foreach ( $option['options'] as $option_key => $option_text ) {
                                            if ( '' === $option_key ) {
                                                // If we have a blank option, select2 needs a placeholder.
                                                if ( empty( $option['placeholder'] ) ) {
                                                    $option['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                                                }
                                                $custom_attributes[] = 'data-allow_clear="true"';
                                            }
                                            $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
                                        }
                                    
                                        $field .= '<select style="width: 100%;" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_name ) . '" class="select ' . esc_attr( implode( ' ', $option['class'] ) ) . '"  data-value="'.$value.'" data-placeholder="' . esc_attr( $option['placeholder'] ) . '">
                            							' . $options . '
                            						</select>';
                                      }
                                      echo $field;
                                    break;
                            }
                        }
                      ?> 
                      <?php endif; ?>
                    </div>
                    
                </div>
            <?php endforeach; ?>
        </div>
    </div>
  <div class="shipping-address">
      <div class="form-group row info">
        <label class="title-name"><?php esc_html_e( 'address Shipping', 'myaccount' ); ?></label>
          <div class="edit-text">
              <div class="hidden-input"></div>
              <u class="shipping-address-click">
                  <span><?php esc_html_e( 'Edit', 'myaccount' ); ?></span>
                  <img src="<?php child_theme_assets('assets/images/common/pain.png'); ?>" alt="">
              </u>
              <input type="text" class="form-control input-text" value="<?php echo $shipping_adress; ?>" >
          </div>
<!--        <div class="col-sm-8 txt"><?php /*echo $shipping_adress; */?></div>-->
      </div>
        <div class="shipping-address-detail">
            <?php 
            foreach ($shipping_fields as $field_name => $option): 
            $value = $user->{$field_name};
            ?>
                <div class="form-group row <?php echo $field_name ?>">
                    <label class="title-name" for="<?php echo $field_name ?>"><?php echo $option['label']; ?> <?php if ($option['required']): ?><span class="required"></span><?php endif; ?></label>
                    <div class="edit-text">
                      <?php
                      if(empty($option['type'])){
                          ?>
                          <input type="text" class="form-control input-text" name="<?php echo $field_name ?>" id="<?php echo $field_name ?>" value="<?php echo esc_attr( $user->{$field_name} ); ?>" />
                          <?php 
                      }
                      else{
                          switch ($option['type']){//country
                              case 'select':
                                  $field   = '';
                                  $options = '';
                                  if ( ! empty( $option['options'] ) ) {
                                      foreach ( $option['options'] as $option_key => $option_text ) {
                                          if ( '' === $option_key ) {
                                              // If we have a blank option, select2 needs a placeholder.
                                              if ( empty( $option['placeholder'] ) ) {
                                                  $option['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
                                              }
                                              $custom_attributes[] = 'data-allow_clear="true"';
                                          }
                                          $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
                                      }
                                  
                                      $field .= '<select style="width: 100%;" name="' . esc_attr( $field_name ) . '" id="' . esc_attr( $field_name ) . '" class="select ' . esc_attr( implode( ' ', $option['class'] ) ) . '"  data-value="'.$value.'" data-placeholder="' . esc_attr( $option['placeholder'] ) . '">
                          							' . $options . '
                          						</select>';
                                    }
                                    echo $field;
                                  break;
                          }
                      }
                      ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
  </div>

  <div class="row submit">
    <div class="col text-center">
      <?php wp_nonce_field( 'save_account_details' ); ?>
      <button type="submit" class="button" name="save_account_details" value="<?php esc_attr_e( 'Save', 'myaccount' ); ?>"><?php esc_html_e( 'Save', 'myaccount' ); ?></button>
      <input type="hidden" name="action" value="save_account_details" />
    </div>
  </div>

  <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
