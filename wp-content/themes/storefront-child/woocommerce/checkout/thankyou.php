<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_template_part('woocommerce/_breadcrumb-cart-checkout');
?>
<div class="thank-page">
    <div class="container">
        <div class="woocommerce-order content-page">
            <div class="bang-detail">
                <div class="detail-page">                    
                    <h1 class="confirmation-title"><?php echo __('Congratulation', 'thankyou'); ?></h1>
                    <div class="confirmation-text">                    
                        <?php
                        $order_id = $order ? $order->get_order_number() : 'checking...';                    
                        $txt = '<p>Your order has just been sent to Company and will be deliver to your provided address shortly.<br>'
                            . 'Your order ID is <strong>@order_id</strong></p>'
                            . '<p>Attention: Please pay to delivery man when receiving your parcel. Specially, don\'t forget to check your parcel to find your Official Prize Document.</p>'
                            . '<p>Once again, congratulation.<br>'
                            . 'We are looking forward to meeting you at the up coming Award Ceremony.</p>'
                            . '<br/>'
                            . '<p>If you need any support, please call 1900.6440<br>'
                            . 'From: 7:00 - 22:00, Monday to Sunday<br>'
                            . 'Fee: 1000d/min</p>';
                        $tranlated_text = str_replace('@order_id', $order_id, __($txt, 'thankyou'));
                        echo $tranlated_text;
                        ?>
                    </div>
                    <a class="bf-title" href="<?php echo site_url('game');?>"><?php echo _e('Back to the homepage', 'thankyou')?></a>                                            
                </div>
                <div class="hd-people hd-desktop">
                    <img src="<?php echo child_theme_assets('assets/images/common/hongdao.png') ?>" alt="">
                </div>
                <div class="hd-people hd-mobile">
                    <img src="<?php echo child_theme_assets('assets/images/common/hongdao-mobile.png') ?>" alt="">
                </div>
            </div>            
        </div>
    </div>
</div>

