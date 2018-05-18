<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Game List
 *
 * @package storefront-child
 */

get_header(); ?>
<div class="block-game-list bf-content-cover bf-padding bf-default-bg">
  <div class="container clearfix">
    <div class="row">
      <div class="col-md-12">
        <div class="block-title text-center">    
        <h1 class="bf-title"><?php echo __("Game page", "game"); ?></h1>
        </div>
      </div>
    </div>
  </div>
  <div class="block-content container clearfix">
    <?php if ( !have_posts() ): ?>
      <div class="row clearfix">
        <div class="col-md-12"><?php echo __("Have no game", "game"); ?></div>
      </div>
    <?php else: ?>
      <div class="row game-item-list clearfix">
        <?php while ( have_posts() ) : the_post(); ?>
          <div class="game-item-wrap col-md-6">
            <?php get_template_part('content-type/game'); ?>
          </div>
        <?php endwhile; ?>
      </div>            
    <?php endif; ?>
    <?php bf_pager(); ?>
  </div>
</div>

<?php
get_footer();