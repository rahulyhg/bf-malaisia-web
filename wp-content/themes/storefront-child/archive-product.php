<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Product List
 *
 * @package storefront-child
 */

get_header(); ?>
<div class="block-product-list bf-content-cover bf-padding bf-default-bg">
  <div class="container clearfix">
    <div class="row">
      <div class="col-md-12">
        <div class="block-title text-center">    
          <h1 class="bf-title"><?php echo __("Best product for you", "product"); ?></h1>
        </div>
      </div>
    </div>
  </div>  
  <div class="block-content container clearfix">
    <div class="row">
      <div class="col-md-4 text-center">
        <a class="btn btn-product-list-header dialog-trigger visible-desktop" role="button" href="javascript:void(0);"
        data-target="#modal-money-back-guarantee">
          <?php //echo __("Money Back Guarantee", "product"); ?>
		      <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/money_refund.png';?>" />
        </a>
        <a class="btn btn-product-list-header visible-mobile" role="button" href="<?php echo home_url('money-back-guarantee'); ?>">
    			<?php //echo __("Money Back Guarantee", "product"); ?>
    			<img src="<?php echo get_stylesheet_directory_uri().'/assets/images/money_refund.png';?>" />
    		</a>
      </div>
      <div class="col-md-4 text-center">        
        <a class="btn btn-product-list-header dialog-trigger" role="button" href="javascript:void(0);" data-target="#modal-customer-review">
          <?php //echo __("How to order", "product"); ?>
          <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/customer_review.png';?>" />
        </a>
      </div>
      <div class="col-md-4 text-center">        
        <a class="btn btn-product-list-header" role="button" href="<?php echo home_url('how-to-order'); ?>">
    			<?php //echo __("How to order", "product"); ?>
    			<img src="<?php echo get_stylesheet_directory_uri().'/assets/images/how_to_order.png';?>" />
    		</a>
      </div>    	  
    </div>
    <?php if ( !have_posts() ): ?>
      <div class="row clearfix">
        <div class="col-md-12"><?php echo __("Have no products", "product"); ?></div>
      </div>
    <?php else: ?>
      <?php if ($wp_query->max_num_pages > 1): bf_pager(); endif; ?>
      <div class="row clearfix">
        <?php while ( have_posts() ) : the_post(); ?>
          <div class="col-md-6">
            <?php get_template_part('content-type/product'); ?>
          </div>
        <?php endwhile; ?>
      </div>
      <?php if ($wp_query->max_num_pages > 1): bf_pager(); endif; ?>
    <?php endif; ?>
  </div>
  <div class="order-now">
      <?php
      $cart_id = get_option( 'woocommerce_cart_page_id' );
      $cart_uri = get_page_uri($cart_id);
      ?>
      <a href="<?php echo $cart_uri?>"><?php _e('Order Now','bf')?></a>
  </div>
</div>

<?php
get_footer();
