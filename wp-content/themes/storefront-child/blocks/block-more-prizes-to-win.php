<?php
/**
 * Availabale variables:
 *  - $block: Array - Block item.
 */
?>
<div class="more-prizes bf-blocks">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="block-title text-center">
                    <h2><?php echo $block["block_title"]; ?></h2>
                </div>
            </div>
        </div>
        <div class="row image-zone bf-row">
            <?php foreach ($block['item'] as $item): ?>
                <div class="col-md-6 col-xs-12 img-row bf-items">
                    <div class="img images-hover">
                        <?php 
                        if(empty($item['link'])){
                            echo bf_render_acf_image($item['image']);
                        }else{
                            echo '<a href="'.$item['link'].'">'.bf_render_acf_image($item['image']).'</a>';
                        }
                        ?>
                    </div><br />
                    <h4><span><?php echo $item['title']; ?></span></h4>
                    <h5><span><?php echo $item['sub_title']; ?></span></h5>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if(!empty($block['description'])): ?>
            <div class="text"><?php echo $block['description']; ?></div>
        <?php endif;?>
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="text-center see-more-row">
                    <a class="btn btn-default btn-see-more" href="<?php echo $block["see_more"]; ?>" role="button"><?php echo __("See more", "homepage"); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
