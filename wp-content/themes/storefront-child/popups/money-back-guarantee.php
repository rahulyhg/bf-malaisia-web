<?php
    $post_data = bf_get_field_acf_group('money_back_guarantee_page');
    $content = apply_filters('the_content', $post_data->post_content);
?>
<div class="modal bd-example-modal-lg fade" id="modal-money-back-guarantee" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo get_the_title($post_data); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span  class="close-popup" aria-hidden="true"></span>
            </button>
        </div>
        <div class="modal-body"><?php echo $content; ?></div>
    </div>
    </div>
</div>
