<div class="modal fade" id="popup-subscription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo get_field('subscription_title', 'option'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  class="close-popup" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo do_shortcode('[bf_subscription_form]'); ?>
            </div>
        </div>
    </div>
</div>