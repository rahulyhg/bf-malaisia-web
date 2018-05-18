<div class="modal fade" id="modal-login-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content login-popup">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo __('You are our customer?', 'bf'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span  class="close-popup" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body sign-in-account">
                <?php echo do_shortcode('[bf_login_form]'); ?>
            </div>
        </div>
    </div>
</div>