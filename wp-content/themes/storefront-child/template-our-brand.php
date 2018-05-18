<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Our brand
 *
 * @package storefront-child
 */

get_header(); ?>
<?php get_template_part('blocks/brand-sponsors'); ?>
<?php bf_get_field_acf_group("blocks"); ?>
<?php
get_footer();
