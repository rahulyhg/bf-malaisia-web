<?php
/**
 * Availabale variables:
 *  - $block: Array - Block item.
 */
?>
<div class="block-articles bf-blocks">
  <div class="container">
    <div class="row clearfix"><div class="col-md-12">
      <div class="block-title text-center">
        <h2><?php echo $block["block_title"]; ?></h2>
      </div>
    </div></div>    
    <div class="row clearfix list bf-row">
      <?php foreach ($block['article'] as $item): setup_postdata($item); ?>
      <div class="col-md-6 article-item bf-items">
        <div class="title"><?php echo $item->post_title; ?></div>
        <div class="text description"><?php the_excerpt(); ?></div>
        <div class="row-readmore">
          <a class="btn-readmore" href="<?php echo get_permalink($item); ?>" role="button"><?php echo __("Readmore >>", "winners"); ?></a>
        </div>
      </div>
      <?php wp_reset_postdata(); ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>
