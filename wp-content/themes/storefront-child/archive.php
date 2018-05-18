<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 *
 * @package storefront-child
 */

get_header(); ?>
<div class="block-product-list bf-padding bf-default-bg">
  <div class="block-title text-center">
    <h1 class="bf-title"><?php echo __("Articles", "post"); ?></h1>
  </div>
  <div class="block-content container clearfix">
    <?php if ( !have_posts() ): ?>
      <div class="row clearfix">
        <div class="col-md-12"><?php echo __("Have no news", "post"); ?></div>
      </div>
    <?php else: ?>
      <div class="row clearfix">
        <?php while ( have_posts() ) : the_post(); ?>
          <div class="col-md-6">
            <?php get_template_part('content-type/post'); ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
    <div class="row pager">
      <div class="col-md-12">
        <?php do_action( 'storefront_loop_after' ); ?>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
