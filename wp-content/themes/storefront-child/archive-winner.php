<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Winner List - Success Stories
 *
 * @package storefront-child
 */

get_header(); ?>
<div class="block-winner-list bf-padding bf-default-bg bf-content-cover">
  <div class="block-title text-center">
    <h1 class="bf-title"><?php echo __("Winners", "winner"); ?></h1>
  </div>
  <div class="block-content container clearfix">
    <?php if ( !have_posts() ): ?>
      <div class="row clearfix">
        <div class="col-md-12"><?php echo __("Have no winner", "winner"); ?></div>
      </div>
    <?php else: ?>
      <?php bf_pager(); ?>
      <div class="row clearfix bf-row">
        <?php while ( have_posts() ) : the_post(); ?>
          <div class="col-md-4 bf-items">
            <?php get_template_part('content-type/winner'); ?>
          </div>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
    <?php bf_pager(); ?>
  </div>
</div>

<?php
get_footer();
