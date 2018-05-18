<?php
/**
 * Availabale variables:
 *  - $block: Array - Block item.
 */
?>

<div class="witness bf-blocks">
    <div class="container">
        <div class="block-title text-center">
            <h2><?php echo $block["block_title"]; ?></h2>
        </div>
        <div class="row">
            <div class="col-md-5 col-xs-12 video">
                <iframe width="570" height="400" src="<?php echo $block['video']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
            <div class="bf-block-witness col-md-6 col-xs-12">
                <div class="text"><?php echo $block["description"]; ?></div>
                <div class="text-center see-more-row">
                    <a class="btn btn-default btn-see-more" href="<?php echo $block["see_more"]; ?>" role="button"><?php echo __("See more", "homepage"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
