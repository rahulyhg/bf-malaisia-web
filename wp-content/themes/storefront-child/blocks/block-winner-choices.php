<div class="container container-no-padding clearfix">
    <div class="product-line-break"></div>
  </div>

  <?php $products = bf_get_field_acf_group('winners_choices'); ?>
  <?php if ($products): ?>    
    <div class="winner-choice-block container clearfix">    
      <div class="row">
        <div class="col-md-12">
          <h3 class="winner-choice-title"><?php echo __("Winner's choices", "product"); ?></h3>
        </div>
      </div>
      <div class="row">
        <?php global $post; ?>
        <?php foreach ($products as $post): ?>
          <?php setup_postdata( $post ); ?>
          <div class="col-md-6">
            <?php get_template_part('content-type/product'); ?>
          </div>
        <?php endforeach; wp_reset_postdata();?>
      </div>
    </div>
  <?php endif; ?>