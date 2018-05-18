<div class="modal bd-example-modal-lg fade" id="modal-cancel-order" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-center">
                    <?php echo __('"Are you sure want to cancel this order?'); ?>
                </p>
                <div class="submit text-center">
                    <button type="button" class="btn" id="acceptCancelOrder" data-dismiss="modal" aria-label="<?php echo __('Yes');?>" value="1"><?php echo __('Yes');?></button>
                    <button type="button" class="btn" data-dismiss="modal" aria-label="<?php echo __('No');?>" value="0"><?php echo __('No');?></button>
                </div>
            </div>
        </div>
    </div>
</div>