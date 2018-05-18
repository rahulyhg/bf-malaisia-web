<?php
  $cart_id = get_option( 'woocommerce_cart_page_id' );
  $cart_uri = get_page_uri($cart_id);

  $checkout_id  = get_option( 'woocommerce_checkout_page_id' );
  $checkout_uri = get_page_uri($checkout_id);

  $url_order_received = get_option( 'woocommerce_checkout_order_received_endpoint', 'order-received' );
  $thankyou_url = $checkout_uri. '/' . $url_order_received . '/%';

$body_classes = get_body_class();
$is_woocommerce_cart_layout = in_array('woocommerce-cart',$body_classes);
$is_woocommerce_checkout_layout = in_array('woocommerce-checkout',$body_classes);
$is_woocommerce_thank_layout = in_array('woocommerce-order-received',$body_classes);

?>
<div class="bg-cart-white">
    <div class="container">
        <ul class="nav nav-pills breadcrumb-cart">
            <li class="nav-item cart <?php bf_add_active_class_menu($cart_uri); ?>">                
                <span class="nav-item-text <?php bf_add_active_class_menu($cart_uri); ?>"><?php echo __("My cart", "cart"); ?></span>
            </li>
            <li class="nav-item billing <?php bf_add_active_class_menu($checkout_uri); ?>">                
            <span class="nav-item-text <?php bf_add_active_class_menu($checkout_uri); ?>"><?php echo __("Delivery address", "cart"); ?></span>
            </li>
            <li class="nav-item thank-you <?php bf_add_active_class_menu($thankyou_url); ?>">                
            <span class="nav-item-text <?php bf_add_active_class_menu($thankyou_url); ?>"><?php echo __("Confirmation", "cart"); ?></span>
            </li>            
            <!-- <li class="nav-item cart <?php bf_add_active_class_menu($cart_uri); ?>">
                <?php if($is_woocommerce_cart_layout): ?>
                    <img src="<?php echo child_theme_assets('assets/images/common/b1-red.png') ?>" alt="">
                <?php else: ?>
                    <img src="<?php echo child_theme_assets('assets/images/common/b1-g.png') ?>" alt="">
                <?php endif;?>
                <?php echo __("My cart", "cart"); ?>
            </li>
            <li class="nav-item billing <?php bf_add_active_class_menu($checkout_uri); ?>">
                <?php if($is_woocommerce_checkout_layout && !$is_woocommerce_thank_layout): ?>
                    <img src="<?php echo child_theme_assets('assets/images/common/b2-red.png') ?>" alt="">
                <?php else: ?>
                    <img src="<?php echo child_theme_assets('assets/images/common/b2-g.png') ?>" alt="">
                <?php endif;?>
                <?php echo __("Delivery address", "cart"); ?>
            </li>
            <li class="nav-item thank-you <?php bf_add_active_class_menu($thankyou_url); ?>">
                <?php if($is_woocommerce_thank_layout && $is_woocommerce_checkout_layout): ?>
                    <img src="<?php echo child_theme_assets('assets/images/common/b3-red.png') ?>" alt="">
                <?php else: ?>
                    <img src="<?php echo child_theme_assets('assets/images/common/b3-g.png') ?>" alt="">
                <?php endif;?>
                <?php echo __("Confirmation", "cart"); ?>
            </li> -->
        </ul>
    </div>
</div>


