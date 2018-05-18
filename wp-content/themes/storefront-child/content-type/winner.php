<?php
$post_id = get_the_ID();
$post_image = get_the_post_thumbnail_url($post_id,'large');
?>
<div id="winner-<?php echo $post_id; ?>" class="winner-item owl-item">
    <div class="winner-img owl-img">
        <img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>" />
    </div>
    <div class="winner-meta-data owl-name">
        <h4 class="winner-title name"><?php the_title(); ?></h4>
        <h5><?php the_excerpt(); ?></h5>
        <div class="winner-des owl-desc">
            <?php  the_content();?>
        </div>
    </div>
</div>
