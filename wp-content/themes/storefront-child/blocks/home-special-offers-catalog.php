<?php
if (!is_user_logged_in()) {
    return ;
}
$data = bf_get_field_acf_group('special_offers_catalog');
?>
<div class="special-offer-catalog bf-blocks <?php if (!$data['special_offer_is_visible']) : echo 'null-offers'; endif; ?>">
    <div class="container">
        <?php if ($data['special_offer_is_visible']) : ?>
            <div class="special-offers flex-item">
                <div class="container">
                    <div class="row detail">
                        <div class="col-md-12 offers">
                            <div class="block-title text-center">
                                <h2><?php echo __("Special offers", "homepage"); ?></h2>
                            </div>
                            <div class="row products">
                                <?php foreach ($data['special_offers'] as $item): ?>
                                    <div class="col-md-4 product-content">
                                        <a class="product-item-image product-popup" href="javascript:void(0);" data-target="<?php echo get_permalink($item['item']); ?>">
                                            <?php echo get_the_post_thumbnail($item['item'], 'thumbnail', array('class' => 'img-fluid')); ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="see-more-row text-center">
                                <a class="btn btn-default btn-see-more" href="<?php echo home_url('products'); ?>" role="button"><?php echo __("See more", "homepage"); ?></a>         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="catalogs flex-item <?php if (!$data['special_offer_is_visible']) :  echo 'bf-custom-title'; endif;?>">
            <div class="container">
                <div class="row detail">
                    <div class="col-md-12 catalog">
                        <div class="block-title text-center">
                            <h2><?php echo __("Catalog", "homepage"); ?></h2>
                        </div>
                        <div class="row products">
                            <?php foreach ($data['catalog'] as $item): ?>
                                <div class="col-md-4 product-content images-hover">
                                    <a class="product-item-image product-popup" href="javascript:void(0);" data-target="<?php echo get_permalink($item['item']); ?>">
                                        <?php echo get_the_post_thumbnail($item['item'], 'thumbnail', array('class' => 'img-fluid')); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="see-more-row text-center">
                            <a class="btn btn-default btn-see-more" href="<?php echo home_url('products'); ?>" role="button"><?php echo __("See more", "homepage"); ?></a>         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
