<?php

global $current_user;
$total_orders = wc_get_customer_order_count($current_user->ID);
?>

<div class="row hello">
    <div class="col-md-12">
        <div class="title-hello">
            <?php $hello = 'Hello %1$s! <span class="recent-destop"> Your recent order <strong>(%2$s)<strong></span>'; ?>
            <?php printf( __($hello, "myaccount"),  esc_html( $current_user->display_name ) ,  $total_orders ); ?>
        </div>
        <div class="logout">
            <a href="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>"><?php echo __("Logout", "myaccount"); ?></a>
        </div>
    </div>
</div>
<div class="row hello rencent-mobile">
    <div class="col-md-12">
        <?php $hello = 'Your recent order (%2$s)'; ?>
        <?php printf( __($hello, "myaccount"),  esc_html( $current_user->display_name ) , '<strong>' . $total_orders . '</strong>'); ?>
    </div>
</div>

<!--<div class="row nav">-->
<!--  <div class="col-md-12 profile-tab">-->
<!--    --><?php //do_action( 'woocommerce_account_navigation' ); ?>
<!--  </div>-->
<!--</div>-->
