<?php
/**
 * These code are overrided a part of file bf-content/plugins/woocommerce/templates/myaccount/orders.php
 * and included in file bf-content/themes/storefront-child/woocommerce/myaccount/my-account.php
 */
do_action( 'woocommerce_before_account_orders', $has_orders ); ?>
<?php if ( $has_orders ) : ?>
<div class="content-order">
  <?php foreach ( $customer_orders->orders as $customer_order ) :
    $order      = wc_get_order( $customer_order );
    $item_count = $order->get_item_count();
    $order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

    $item1 = array_shift($order_items);
    $product = $item1->get_product();
    if($product):
    $product_data = $product->get_data();
    ?>
    <div class="row order-detail">
      <div class="img-order">
        <?php echo get_the_post_thumbnail( $product_data['id'], 'thumbnail' ); ?>
        <?php //echo wp_get_attachment_image( $product['data']['image_id'], 'thumbnail' ); ?>
      </div>
      <div class="product-content">
        <div class="item order-id">
          <label><?php echo __("Order ID", 'myaccount'); ?>: </label>
          <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"><?php echo $order->get_order_number(); ?></a>
        </div>
        <div class="item order-created">
          <label><?php echo __("Date", 'myaccount'); ?>:</label> <?php echo esc_html( wc_format_datetime( $order->get_date_created(), 'd/m/Y' ) ); ?>
        </div>
        <div class="item order-status">
          <label><?php echo __("Status", 'myaccount'); ?>:</label> <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
        </div>
        <div class="h-line"></div>
        <div class="item order-total">
          <label><?php echo __("Price", 'myaccount'); ?>:</label> <?php
            echo  $order->get_formatted_order_total();
            /* translators: 1: formatted order total 2: total order items */
            // printf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
            ?>
        </div>
      </div>
    </div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
  <?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

  <?php if ( 1 < $customer_orders->max_num_pages ) : ?>
    <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
      <?php if ( 1 !== $current_page ) : ?>
        <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php _e( 'Previous', 'woocommerce' ); ?></a>
      <?php endif; ?>

      <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
        <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php _e( 'Next', 'woocommerce' ); ?></a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

<?php else : ?>
  <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
    <a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
      <?php _e( 'Go shop', 'woocommerce' ) ?>
    </a>
    <?php _e( 'No order has been made yet.', 'woocommerce' ); ?>
  </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>

