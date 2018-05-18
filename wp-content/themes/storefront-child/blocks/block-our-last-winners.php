<?php
/**
 * Availabale variables:
 *  - $block: Array - Block item.
 */
$body_classes = get_body_class();
$is_home_page = in_array('home',$body_classes);

?>
<div class="bf-our-winners bf-blocks mobile-slider">
    <div class="container">
        <div class="block-title text-center">
            <h2><?php echo $block["block_title"]; ?></h2>
        </div>
        <div class="owl-carousel owl-theme owl-loaded">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    <?php foreach ($block['item'] as $item): ?>
                    <div class="owl-item col-md-4">
                        <div class="bf-slider-block">
                            <div class="bf-winner img-effect">
                                <div class="owl-img <?php if($is_home_page): echo 'clearfix'; endif; ?> hotfix">
                                        <?php echo bf_render_acf_image($item['image']); ?>
                                </div>
                                <div class="owl-name">
                                    <h4 class="name"><?php echo $item['name']; ?></h4>
                                    <h5><span><?php echo $item['summary']; ?></span></h5>
                                    <div class="winner-des owl-desc">
                                        <?php echo $item['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="text-center see-more-row">
            <a class="btn btn-default btn-see-more" href="<?php echo $block["see_more"]; ?>" role="button"><?php echo __("See more", "homepage"); ?></a>
        </div>
    </div>
</div>