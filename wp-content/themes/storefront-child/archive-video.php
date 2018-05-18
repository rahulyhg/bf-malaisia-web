<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Video List
 *
 * @package storefront-child
 */

get_header(); ?>
<div class="block-product-list bf-content-cover bf-padding bf-default-bg">
    <div class="container">
        <div class="block-title text-center">
            <h1 class="bf-title"><?php echo __("Video", "video"); ?></h1>
        </div>
        <div class="block-content container clearfix">
            <?php bf_pager(); ?>
            <?php if ( !have_posts() ): ?>
                <div class="row clearfix">
                    <div class="col-md-12"><?php echo __("Have no video", "video"); ?></div>
                </div>
            <?php else: ?>
                <div class="row clearfix detail-list">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="list-video">
                            <?php get_template_part('content-type/video'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
            <?php bf_pager(); ?>
        </div>
    </div>
</div>
<?php
get_footer();
