var Product = Product || {};
import 'modules/jquery.slimscroll';
import Cart from 'modules/cart';
(function( $ ) {
    Product = {
        bootstrap : function(){   
            this.productPopup();
        },
        onWindowResize: function(){
            let max_height = $('#modal-product').find('.product-item-meta .woocommerce-product-details__short-description').css('max-height');
            let element_height = $('#modal-product').find('.product-item-meta .short-desc').innerHeight();                 
            if( max_height == 'none'){
                return;
            }
            if(parseInt(element_height) > parseInt(max_height)){
                $('#modal-product').find('.product-item-meta .short-desc').slimScroll({
                    height: parseInt(max_height),
                    railVisible: true,
                    color: '#c2171d'              
                }).trigger('mouseenter');                
            }
        },
        productMetaScrollBar: function(){
            $('#modal-product').on('shown.bs.modal', function(e){
                Product.onWindowResize();
            });
        },
        formatQuantity: function(number){            
            if(number < 10){
                return '0' + number;
            }
            return number
        },
        productPopup: function(){
            this.productMetaScrollBar();
            $('.product-popup').click(function(e){
                e.preventDefault();
                $('#modal-product .modal-body')
                .load($(this).attr('data-target'),function(){
                    let productSliderPager = null;
                    let productSlider = $('#modal-product')
                    .modal('show')
                    .find('.product-slider')
                    .bxSlider({
                        startSlide: 0,
                        controls: false,
                        infiniteLoop:false,
                        pagerCustom: '#product-slider-pager',
                        onSlideAfter: function($slideElement, oldIndex, newIndex){
                            if(productSliderPager!= null){
                                productSliderPager.goToSlide(newIndex);                                
                            }
                        }
                    });

                    productSliderPager = $('#modal-product').find('#product-slider-pager .product-slider-pager-wrap').bxSlider({
                        minSlides: 4,
                        moveSlides: 1,
                        pager: false,
                        infiniteLoop:false,
                        onSlideAfter: function($slideElement, oldIndex, newIndex){
                            productSlider.goToSlide(newIndex);
                        }
                    });

                    let product_quantity = $('#modal-product').find('.product-item-meta .qty').val();
                    $('#modal-product').find('.product-item-meta .qty').val(Product.formatQuantity(product_quantity));

                    $('#modal-product').find('.product-item-meta .quantity-increase').click(function(){
                        let $qty_ele = $(this).siblings('.qty');
                        let qty = parseInt($qty_ele.val());
                        qty = qty + 1;
                        $qty_ele.val(Product.formatQuantity(qty));
                    });
                    $('#modal-product').find('.product-item-meta .quantity-decrease').click(function(){
                        let $qty_ele = $(this).siblings('.qty');
                        let qty = parseInt($qty_ele.val());
                        qty = qty - 1;
                        // make sure qty is always >= 1
                        qty = Math.max(1,qty);
                        $qty_ele.val(Product.formatQuantity(qty));
                    });                    
                    Cart.addToCartHandle($('#modal-product').find('.btn-add-to-cart'),function(data){
                        if(data.status === true){
                            $('#modal-product').modal('hide');
                            setTimeout(function(){ $('#modal-addtocartonpopup').modal('show'); }, 1000);
                        }
                    });
                });
            });
        }
    }   
})(jQuery);

export default Product;
    