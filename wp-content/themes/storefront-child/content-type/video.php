<?php
$post_id = get_the_ID();
$post_image = get_the_post_thumbnail_url($post_id,'large');
$video_url = bf_get_field_acf_group('url');
?>
<div id="video-<?php echo $post_id; ?>" class="video-item">
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" width="570" height="400" src="<?php echo $video_url; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
  <div class="video-meta-data text">
    <?php the_excerpt(); ?>
  </div>
</div>
