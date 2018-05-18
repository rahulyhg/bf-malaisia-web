var Cart = Cart || {};
(function( $ ) {
    Cart = {
        bootstrap : function(){  
            $('.btn-add-to-cart').each(function(index, ele){
                Cart.addToCartHandle($(this), function(data){
                    if(data.status === true){
                        $('#modal-addtocartonpage').modal('show');
                    }
                });
            });
            this.changeNumber();
            this.cancelOrder();
            //Cart.onWindowResize();
        },
        cancelOrder: function(){
            let $modal = $('#modal-cancel-order');
            $(document).ajaxSuccess(function() {
                $('#cancelOrder').on('click', function (events) {
                    events.preventDefault();
                    events.stopPropagation();
                    $modal.find('#acceptCancelOrder').attr('data-redirect', $(this).data('redirect'));
                    $modal.modal('show');
                });
            });

            $modal.on('click', '.btn', function () {
                 !!parseInt(this.value) ?
                     window.location.href = ($(this).data('redirect')) : '';
            });
        },
        onWindowResize: function(){
            let max_height = $('.woocommerce-cart-form.my-cart .my-cart_table-wrapper').css('max-height');            
            let element_height = $('.woocommerce-cart-form.my-cart .my-cart_table-wrapper .my-cart_table').innerHeight();
            if( max_height == 'none'){
                return;
            }            
            if(parseInt(element_height) > parseInt(max_height)){
                $('.woocommerce-cart-form.my-cart .my-cart_table-wrapper').slimScroll({
                    height: parseInt(max_height),
                    railVisible: true,
                    color: '#c2171d'
                });
            }        
        },        
        activeUpdateCart: function(ele){            
            if( ele.parents('.woocommerce-cart-form.my-cart').length > 0 ){
                //ele.parents('.woocommerce-cart-form.my-cart').find('button[name="update_cart"]').html('Đang cập nhật giỏ hàng');                                 
                ele.parents('.woocommerce-cart-form.my-cart').find('button[name="update_cart"]').prop("disabled", false);
                //ele.parents('.woocommerce-cart-form.my-cart').find('button[name="update_cart"]').removeClass('hidden');
                ele.parents('.woocommerce-cart-form.my-cart').find('.checkout-button').click(function(ev){
                    ev.preventDefault();                 
                });
                ele.parents('.woocommerce-cart-form.my-cart').find('button[name="update_cart"]').trigger('click');
            }
        },
        changeNumber : function () {            
            $(".cart_item .quantity-decrease").click(function () {
                let $qty_ele = $(this).siblings('.qty');
                let qty = parseInt($qty_ele.val());
                qty = qty - 1;
                qty = Math.max(1,qty);
                $qty_ele.val(qty);
                Cart.activeUpdateCart($qty_ele);
            });

            $(".cart_item .quantity-increase").click(function () {
                let $qty_ele = $(this).siblings('.qty');
                let qty = parseInt($qty_ele.val());
                qty = qty + 1;
                $qty_ele.val(qty);
                Cart.activeUpdateCart($qty_ele);
            });
        },
        updateMyCarts: function(total_cart_items){
            let $my_cart_items_count = $('.my-carts').find('.my-cart-items-count');
            if($my_cart_items_count.length > 0){
                $my_cart_items_count.html(parseInt(total_cart_items));
            }
        },
        addToCartHandle: function($ele, callback){
            $ele.click(function(evt){                
                evt.preventDefault();
                Cart.addToCartAjaxCallback($ele, callback);
            });
        },
        addToCartAjaxCallback: function($ele, callback){
            let ajax_url = SITE_URL;
            let product_id = $ele.attr('value');
            let product_sku = '';
            let quantity = 1;            
            
            if($ele.parents('form.cart').find('.quantity .input-text').length > 0){
                quantity = parseInt($ele.parents('form.cart').find('.quantity .input-text').val());
                quantity = Math.max(1,quantity);
            }
            $.ajax({
                method: "POST",
                data: { product_sku: product_sku, product_id: product_id, quantity: quantity },
                url: ajax_url + '?wc-ajax=add_to_cart'
            })
            .done(function(data) {             
                if( typeof data.fragments !== 'undefined' ){
                    let $cart_contents = $('.my-carts .cart-hidden');
                    $cart_contents.empty();
                    let cart_content_html = data.fragments['a.cart-contents'];
                    let total_cart_items = parseInt($cart_contents.append($.parseHTML(cart_content_html))
                    .find('.count').html());
                    Cart.updateMyCarts(total_cart_items);  
                    callback({status:true, total_cart_items: total_cart_items})                  
                }else{
                    // show errors
                    if (typeof callback === "function") {
                        callback({status:false, errors: 'something wrongs!'});
                    }                    
                }
            })
            .fail(function(errors) {
                callback({status: false, errors: errors});     
            });
            // .always(function() {
            // });
            
        }
    }   
})(jQuery);

export default Cart;
    