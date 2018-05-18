<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices();

/**
 * My Account navigation.
 * @since 2.6.0
 */

// Get order data
if (!isset($customer_orders) && !isset($has_orders)) {
    // Load data at my account page.
    $current_page    = empty( $current_page ) ? 1 : absint( $current_page );
    $customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array(
        'customer' => get_current_user_id(),
        'page'     => $current_page,
        'paginate' => true,
    ) ) );

    $has_orders = (0 < $customer_orders->total);
}

$hide_header_on_edit_account_form = true;
?>
<?php include "_my-account-header.php" ?>
<div class="container myaccount">
    <div class="show-desktop">
        <ul class="nav nav-pills">
            <li class="nav-item tab-order">
                <a class="nav-link active" data-toggle="pill" href="#oder"><?php _e('Order History','my-account'); ?></a>
            </li>
            <li class="nav-item tab-informaton">
                <a class="nav-link" data-toggle="pill" href="#information"><?php _e('User Infomation','my-account') ?></a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-order-mobile"><?php _e('Order History','my-account'); ?>
            <div class="icon-up"></div>
            <div class="icon-down"></div>
        </div>
        <div class="row orders tab-pane fade show active" id="oder">
            <div class="col-md-12"><?php include "_my-account-orders-list.php"; ?></div>
        </div>
        <div class="box"></div>
        <div class="tab-informaton-mobile"><?php _e('User Infomation','my-account') ?>
            <div class="icon-up"></div>
            <div class="icon-down"></div>
        </div>
        <div class="row edit-account tab-pane fade show" id="information">
            <div class="col"><?php include "form-edit-account.php"; ?></div>
        </div>
    </div>
</div>


