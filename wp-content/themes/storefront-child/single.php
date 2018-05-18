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
			<?php the_title(); ?>
            <?php the_content(); ?>
		</div>
	</div>
<?php
get_footer();
