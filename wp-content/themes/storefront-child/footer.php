</main><!-- end #page-content -->
<footer id="page-footer">
    <div class="container clearfix">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'footer_menu',
            'container' => '',
            'container_class' => '',
            'container_id' => '',
            'depth' => 3,
            'items_wrap' => '<ul id="%1$s" class="%2$s footer-menu clearfix">%3$s</ul>',
        ));
        ?>
    </div>
</footer>

<?php get_template_part('parts/foot');?>
<script type="text/javascript">
    jQuery( document.body ).on( 'updated_cart_totals', function() {     
        jQuery.post(
            AJAX_URL, 
            {
                'action': 'my_cart_items_count'         
            }, 
            function(response){                
                if(jQuery('.my-carts').find('.my-cart-items-count').length > 0){
                    jQuery('.my-carts').find('.my-cart-items-count').html(parseInt(response));
                }                
            }
        );              
    });    
</script>
<div class="modal bd-example-modal-lg fade" id="modal-message-less-one" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span  class="close-popup" aria-hidden="true"></span>
            </button>
        </div> -->
        <div class="modal-body">
            <p class="text-justify">
                <?php echo __('Hãy đặt đơn hàng trên 1.000.000 đồng để có thêm cơ hội thắng giải thưởng.'); ?>            
            </p>
            <div class="submit text-center">
                <button type="button" class="btn" data-dismiss="modal" aria-label="<?php echo __('OK');?>"><?php echo __('OK');?></button>
            </div>            
        </div>
    </div>
    </div>
</div>

<div class="modal bd-example-modal-lg fade" id="modal-message-browser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span  class="close-popup" aria-hidden="true"></span>
            </button>
        </div> -->
        <div class="modal-body">
            <p class="text-justify">
                <?php echo __('Hãy đặt đơn hàng trên 1.000.000 đồng để có thêm cơ hội thắng giải thưởng.'); ?>            
            </p>
            <div class="submit text-center">
                <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="<?php echo __('OK');?>"><?php echo __('OK');?></button>
                <button type="button" class="btn btn-cancel" data-dismiss="modal" aria-label="<?php echo __('Cancel');?>"><?php echo __('Cancel');?></button>
            </div>            
        </div>
    </div>
    </div>
</div>



<?php if(is_page('cart')) { ?>
        <?php global $woocommerce;?>
        <script type="text/javascript">
            var checkout_url = '<?php echo esc_url( wc_get_checkout_url() );?>';
            var total_order = "<?php echo $woocommerce->cart->total;?>";
            var d_price = 1000000;
            jQuery(function(){
                var count_click = 0;
                jQuery('.checkout-button').click(function(){
                    if(total_order < d_price) {
                                                //alert('Hãy đặt đơn hàng trên 1.000.000 đồng để có thêm cơ hội thắng giải thưởng.');
                        if(count_click == 0){
                            count_click = count_click + 1;
                            jQuery('#modal-message-less-one').modal('show');
                        }else{
                            window.location.href = '<?php echo esc_url( wc_get_checkout_url() );?>';
                        }    
                    }else{
                        window.location.href = '<?php echo esc_url( wc_get_checkout_url() );?>';
                    }
                });
            });
        </script>

        <script type="text/javascript">
            // window.onbeforeunload = function (event) {
            // //     //var message = 'Important: Please click on \'Save\' button to leave this page.';
            //     if (typeof event == 'undefined') {
            //         jQuery('#modal-message-browser').modal('show');
            //     }else if (event) {
            //         jQuery('#modal-message-browser').modal('show');
            //     }
            //     return false;
            // };

            /*
            jQuery(window).on('beforeunload', function(){
                  jQuery('#modal-message-browser').modal('show');
                  return false;
            });
            */



            /*
            window.onbeforeunload = confirmExit;
            function confirmExit(){
                jQuery('#modal-message-browser').modal('show');
                return false;
            }
            */
            //jQuery('#modal-message-browser').modal('show');
            //jQuery('.my-carts').attr('href','javascript:void(0);');
            /* Ok  popup*/
            // var validNavigation = false;

            // // Attach the event keypress to exclude the F5 refresh (includes normal refresh)
            // jQuery(document).bind('keypress', function(e) {
            //     if (e.keyCode == 116){
            //         validNavigation = true;
            //     }
            // });

            // // Attach the event click for all links in the page
            // jQuery("a").bind("click", function() {
            //     validNavigation = true;
            // });

            // // Attach the event submit for all forms in the page
            // jQuery("form").bind("submit", function() {
            //   validNavigation = true;
            // });

            // // Attach the event click for all inputs in the page
            // jQuery("input[type=submit]").bind("click", function() {
            //   validNavigation = true;
            // });


            // window.onbeforeunload = function(event) {                
            //     //if (!validNavigation) {     
            //         jQuery('#modal-message-browser').modal('show');
                   
            //         return false;
            //     //}
            // };
           
            
            
            // jQuery('.btn-close').click(function(){
            //     var win = window.open("about:blank", "_self");
            //     win.close();
            //     return false;
            // });



            /* Ok  popup*/

        </script>
<?php } ?>

<?php if(is_shop()):?>
        <script>
            jQuery(document).bind("contextmenu cut copy",function(e){
                e.preventDefault();
                alert('Copying is not allowed');
            });
        </script>
<?php endif;?>