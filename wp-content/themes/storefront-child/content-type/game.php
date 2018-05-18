<?php
$post_id = get_the_ID();
$post_image = get_the_post_thumbnail_url($post_id,'large');
?>
<div id="game-<?php echo $post_id; ?>" class="game-item">
  <?php if ($post_image): ?>
    <a class="game-item-image images-hover" href="<?php the_permalink(); ?>" data-target="<?php the_permalink(); ?>" style="background-image:url('<?php echo $post_image; ?>');">
        <img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>" />
    </a>
  <?php endif; ?>
    <div class="game-item-meta">
        <h3 class="game-item-title"><?php the_title(); ?></h3>
        <div class="game-excerpt text">
          <?php the_excerpt(); ?>
        </div>
        <div class="game-buttons">
          <a data-title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" 
          class="btn btn-default btn-playnow"><?php echo __('Play now','game'); ?></a>
        </div>
    </div>
</div>