<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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

wc_print_notices();

get_template_part('woocommerce/_breadcrumb-cart-checkout');

do_action( 'woocommerce_before_cart' ); ?>

<div class="bf-cart-block">
    <form class="woocommerce-cart-form my-cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>
        <div class="my-cart_table-wrapper">
            <div class="my-cart_table table">            
                <div class="my-cart_row my-cart_head">
                    <div class="my-cart_col col-remove">&nbsp;</div>
                    <div class="my-cart_col col-stt"><?php esc_html_e( 'STT', 'woocommerce' ); ?></div>
                    <div class="my-cart_col col-id"><?php esc_html_e( 'ID', 'woocommerce' ); ?></div>
                    <div class="my-cart_col col-picture"><?php esc_html_e( 'Product Picture', 'woocommerce' ); ?></div>
                    <div class="my-cart_col col-product"><?php esc_html_e( 'Product', 'woocommerce' ); ?></div>
                    <div class="my-cart_col col-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></div>
                    <div class="my-cart_col col-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></div>
                    <div class="my-cart_col col-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
                </div>                        
                
                <?php do_action( 'woocommerce_before_cart_contents' ); ?>
                <?php 
                    $cart_items = WC()->cart->get_cart();
                    $cart_items = array_reverse($cart_items);
                    $count = 0;
                    foreach ( $cart_items as $cart_item_key => $cart_item ) {
                        $count ++;
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                    <div class="my-cart_row woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                        <div class="my-cart_col col-remove">
                            <?php
                            // @codingStandardsIgnoreLine
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="cart-icon-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                __( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                            ), $cart_item_key );
                            ?>                            
                        </div>
                        <div class="my-cart_col col-stt">
                            <?php echo $count; ?>
                        </div>
                        <div class="my-cart_col col-id">
                            <?php echo $product_id; ?>
                        </div>
                        <div class="my-cart_col col-picture">
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                            if ( ! $product_permalink ) {
                                echo $thumbnail;
                            } else {
                                printf( '<a class="product-popup" data-target="%s" href="javascript:void(0);">%s</a>', esc_url( $product_permalink ), $thumbnail );
                            }
                            ?>
                        </div>
                        <div class="my-cart_col col-product">
                            <div class="product-name">                                                    
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                                // if ( ! $product_permalink ) {
                                //     echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
                                // } else {
                                //     echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
                                // }

                                // Meta data.
                                echo wc_get_formatted_cart_item_data( $cart_item );

                                // Backorder notification.
                                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                    echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
                                }
                                ?>
                            </div>                        
                        </div>
                        <div class="my-cart_col col-price">
                            <?php
                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                            ?>
                        </div>
                        <div class="my-cart_col col-quantity">
                            <?php
                            if ( $_product->is_sold_individually() ) {
                                $product_quantity = sprintf( '1 <input class="amount" type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                            } else {
                                $product_quantity = woocommerce_quantity_input( array(
                                    'input_name'    => "cart[{$cart_item_key}][qty]",
                                    'input_value'   => $cart_item['quantity'],
                                    'max_value'     => $_product->get_max_purchase_quantity(),
                                    'min_value'     => '0',
                                    'product_name'  => $_product->get_name(),
                                ), $_product, false );
                            }

                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );?>                    
                        </div>
                        <div class="my-cart_col col-total">
                            <div class="col-total-inner">
                                <span class="total-label">
                                    <?php esc_attr_e( 'Total', 'woocommerce' ); ?>
                                </span>
                                <?php
                                echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                                ?>                    
                            </div>
                        </div>
                        <?php do_action( 'woocommerce_cart_contents' ); ?>
                    </div><!-- end my-cart_row -->
                <?php
                        }
                    }
                ?>                                    
            </div><!-- end my-cart_table -->
        </div><!-- end my-cart_table-wrapper -->
        <div class="my-cart_foot text-center">
            <?php if ( wc_coupons_enabled() ) { ?>
                <div class="coupon">
                    <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>" />
                    <?php do_action( 'woocommerce_cart_coupon' ); ?>
                </div>
            <?php } ?>            
            <?php do_action( 'woocommerce_cart_actions' ); ?>
            <?php wp_nonce_field( 'woocommerce-cart' ); ?>
            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>                
        </div><!-- end my-cart_foot -->        
        <div class="cart-collaterals">
        <?php
            /**
             * Cart collaterals hook.
             *
             * @hooked woocommerce_cross_sell_display
             * @hooked woocommerce_cart_totals - 10
             */
            do_action( 'woocommerce_cart_collaterals' );
        ?>        
        </div>        
    </form>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
