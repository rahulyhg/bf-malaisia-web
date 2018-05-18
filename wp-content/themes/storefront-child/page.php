<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */
$body_classes = get_body_class();
$is_woocommerce_cart_layout = in_array('woocommerce-cart',$body_classes);
$is_woocommerce_cart_layout |= in_array('woocommerce-checkout',$body_classes);
get_header();

while ( have_posts() ) : the_post();
?>
    <?php if($is_woocommerce_cart_layout): ?>
        <div class="bf-content-cover bf-default-bg bf-cart <?php if(in_array('woocommerce-checkout',$body_classes)) : echo 'bf-checkout-block'; endif;?>">
<!--            <div class="bg-cart-white bg-cart-header">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <h1 class="bf-page-title"><?php /*echo the_title();*/?></h1>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php the_content();?>
        </div>
        <?php else: ?>
        <div class="bf-content-cover bf-default-bg bf-padding">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <h1 class="bf-page-title"><?php echo the_title();?></h1>
                        <div class="bf-page-content">
                            <?php the_content();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
<?php
endwhile; // End of the loop.

get_footer();
