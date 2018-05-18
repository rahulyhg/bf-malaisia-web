<?php
global $bf_upload_url;
$post_id = get_the_ID();
$post_image = $bf_upload_url . '/assets/images/common/product-image.jpg';
if (has_post_thumbnail()) {
  $post_image = get_the_post_thumbnail_url($post_id,'medium');
}
?>
<div id="post-<?php echo $post_id; ?>" class="post-item">
  <?php if ($post_image): ?>
  <a class="post-img" href="<?php the_permalink(); ?>" style="background-image:url('<?php echo $post_image; ?>');">
    <img width="300" src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>" />
  </a>
  <?php endif; ?>
  <div class="post-meta-data text">
    <a href="<?php the_permalink(); ?>" class="post-title"><?php the_title(); ?></a>
    <?php the_excerpt(); ?>
  </div>
</div>
