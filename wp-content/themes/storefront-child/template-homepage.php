<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront-child
 */

get_header();
get_template_part('blocks/home-banner');
?>
<?php
// Get and render blocks.
bf_get_field_acf_group("blocks");
get_template_part('blocks/home-special-offers-catalog');
get_template_part('blocks/block-subscription');
?>

<?php
get_template_part('popups/subscription');
get_footer();
