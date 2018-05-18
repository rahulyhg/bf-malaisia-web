<?php
/**
 * Availabale variables:
 *  - $block: Array - Block item.
 */
?>
<div class="about-us bf-blocks">
    <div class="container">
        <div class="block-title text-center">
            <h2 class="bf-title"><?php echo $block["block_title"]; ?></h2>
        </div>
        <div class="row about-us-content">
            <div class="bf-block-about col-md-6 bf-content-descrition">
                <h4 class="title"><?php echo $block['sub_title']; ?></h4>
                <div class="text"><?php echo $block['description']; ?></div>
            </div>
            <div class="img-right col-md-6 bf-image">
                <?php echo bf_render_acf_image($block['image']); ?>
            </div>
        </div>
    </div>
</div>
