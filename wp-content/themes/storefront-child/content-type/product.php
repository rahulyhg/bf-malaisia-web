<?php
$post_id = get_the_ID();
$post_image = get_the_post_thumbnail_url($post_id,'large');
?>
<div id="product-<?php echo $post_id; ?>" class="product-item">
  <?php if ($post_image): ?>
    <a class="product-item-image product-popup product-hover" href="javascript:void(0);" data-target="<?php the_permalink(); ?>" style="background-image:url('<?php echo $post_image; ?>');">
        <img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>" />
    </a>
  <?php endif; ?>
    <div class="product-item-meta text">
        <h3 class="product-item-title"><?php the_title(); ?></h3>
        <?php woocommerce_template_single_excerpt(); ?>    
        <?php woocommerce_template_single_price(); ?>
        <?php woocommerce_template_single_add_to_cart(); ?>
    </div>
</div>