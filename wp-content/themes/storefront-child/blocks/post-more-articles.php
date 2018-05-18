<?php
global $wpdb,$sitepress;
$sql = "SELECT * FROM $wpdb->posts p JOIN {$wpdb->prefix}icl_translations t ON t.element_id = p.ID AND t.element_type='post_post'  WHERE post_type = 'post' AND post_status = 'publish' AND language_code = '".$sitepress->get_current_language()."' AND post_date <= '$post->post_date' AND ID <> $post->ID  ORDER BY post_date DESC, ID DESC LIMIT 5";
$results = $wpdb->get_results( $sql );
$output = array();
if ( $results ) {
    foreach ( (array) $results as $result ) {
        if($link = bf_get_archives_link($result)){
            $output[] = $link;
        }
    }
}
if(count($output) < 5){
    $sql = "SELECT * FROM $wpdb->posts p JOIN {$wpdb->prefix}icl_translations t ON t.element_id = p.ID AND t.element_type='post_post'  WHERE post_type = 'post' AND post_status = 'publish' AND language_code = '".$sitepress->get_current_language()."' AND post_date > '$post->post_date' AND ID <> $post->ID  ORDER BY post_date DESC, ID DESC LIMIT 5";
    $results = $wpdb->get_results( $sql );
    if ( $results ) {
        foreach ( (array) $results as $result ) {
            if(count($output) == 5) break;
            if($link = bf_get_archives_link($result)){
                $output[] = $link;
            }
        }
    }
}
?>

<div class="more-post">
  <h4 class="title text-center"><?php echo __("More articles", "post"); ?></h4>
  <?php if (count($output)) : ?>
    <ul class="list">
      <?php echo implode('', $output); ?>
    </ul>
  <?php endif; ?>
</div>
