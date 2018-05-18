<?php
/**
 * The template for displaying the single page.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: FullWidth
 *
 * @package storefront-child
 */

get_header(); ?>
	<div class="block-product-list bf-padding bf-default-bg">
		<div class="block-title text-center">
			<h1 class="bf-title"><?php echo the_title();?></h1>
		</div>
	</div>	
<?php
get_footer();
