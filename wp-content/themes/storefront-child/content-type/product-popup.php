<?php
$post_id = get_the_ID();
$post_image = get_the_post_thumbnail_url($post_id,'large');
$post_thumbnail_image = get_the_post_thumbnail($post_id,'large');
$product = wc_get_product($post_id);
$attachment_ids = $product->get_gallery_attachment_ids();
$empty_gallery_class = empty($attachment_ids) ? 'empty-gallery' : '';
?>
<div id="product-popup-item-<?php echo $post_id; ?>" class="product-popup-item">
    <div class="product-image-col <?php echo $empty_gallery_class; ?>">
        <?php if(!empty($attachment_ids)) : ?>
        <div class="product-slider-wrapper">
            <div id="product-slider" class="product-slider">            
                <?php
                    $product_slider_pager = '';
                    $loop = 1;
                    // 1st image
                    echo sprintf('<div data-index="' . '0' . '" class="product-slider-item" style="background-image:url(\'%s\')"></div>', $post_image);
                    $product_slider_pager .= sprintf('<a class="product-slider-pager-item" data-slide-index="%s" href="javascript:void(0);">%s</a>', 0, $post_thumbnail_image);                                        
                    foreach ( $attachment_ids as $attachment_id ) {
                        $image_link = wp_get_attachment_url( $attachment_id );
                        if ( ! $image_link )
                            continue;
                        $image_title = esc_attr( get_the_title( $attachment_id ) );
                        $image_caption = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

                        $image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ), 0, $attr = array(
                            'title' => $image_title,
                            'alt'   => $image_title
                            ) );

                        $image_thumb = apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '%s', $image ), $attachment_id, $post_id, $image_class );
                        echo sprintf('<div data-index="' . $loop . '" class="product-slider-item" style="background-image:url(\'%s\')"></div>', $image_link);
                        $product_slider_pager .= sprintf('<a class="product-slider-pager-item" data-slide-index="%s" href="javascript:void(0);">%s</a>', $loop, $image_thumb);
                        $loop++;
                    }
                ?>
            </div>
            <div id="product-slider-pager">
                <div class="product-slider-pager-wrap">
                    <?php echo $product_slider_pager; ?>
                </div>
            </div>
        </div> 
        <?php else:?>
            <a class="product-item-image" href="javascript:void(0);" style="background-image:url('<?php echo $post_image; ?>');">
                <img src="<?php echo $post_image; ?>" alt="<?php the_title(); ?>" />
            </a>
        <?php endif; ?>
    </div>
    <div class="product-item-meta text <?php echo $empty_gallery_class; ?>">
        <h3 class="product-item-title"><?php the_title(); ?></h3>
        <?php woocommerce_template_single_excerpt(); ?>    
        <?php woocommerce_template_single_price(); ?>
        <?php woocommerce_template_single_add_to_cart(); ?>
    </div>
</div>