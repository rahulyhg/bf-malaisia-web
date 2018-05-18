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

get_header();
?>
<div class="bf-content-cover bf-padding bf-default-bg">
  <div class="container">
    <div class="row post-content-wrap">      
      <div class="col-md-6 post-second-col">
        <h1 class="post-title"><?php echo the_title();?></h1>
        <div class="post-image visible-mobile">
          <?php the_post_thumbnail('full'); ?>
          <?php if (!has_post_thumbnail()): ?>
            <img class="wp-post-image" src="<?php child_theme_assets('assets/images/common/product-image.jpg');?>" alt="Default image" />
          <?php endif; ?>
        </div>        
        <div class="post-content text">
            <?php the_content();?>
        </div>
      </div>
      <div class="col-md-6 post-first-col">
        <div class="post-image visible-desktop">
          <?php the_post_thumbnail('full'); ?>
          <?php if (!has_post_thumbnail()): ?>
            <img class="wp-post-image" src="<?php child_theme_assets('assets/images/common/product-image.jpg');?>" alt="Default image" />
          <?php endif; ?>
        </div>
        <?php get_template_part('blocks/post-more-articles'); ?>
      </div>      
    </div>
  </div>
</div>
<?php
get_footer();
