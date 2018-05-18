<?php
/**
 * Availabale variables:
 *  - $block: Array - Block item.
 */
?>
<div class="why-us bf-blocks">
    <div class="container">
        <div class="block-title text-center">
            <h2 class="bf-title"><?php echo $block["block_title"]; ?></h2>
        </div>
        <div class="row list bf-row">
            <?php foreach ($block['list'] as $item): ?>
                <div class="col-md-3 bf-items">
                    <div class="title">
                        <h4><?php echo $item['title']; ?></h4>
                    </div>
                    <div class="detail">
                        <?php echo bf_render_acf_image($item['image']); ?>
                        <p class="desc bf-us-description"><?php echo $item['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
