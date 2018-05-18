<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
// $menus = wc_get_account_menu_items();
// var_dump('<pre>', $menus, '</pre>');

global $wp;
$current_url = get_site_url(NULL, $wp->request . "/");
if (strpos($wp->request, 'my-account/orders') === 0) {
  $current_url = wc_get_account_endpoint_url( 'dashboard' );
}

$navs = [
  'dashboard' => __("Order history", "myaccount"),
  'edit-account'  => __("User infomation", "myaccount")
];
?>

<ul class="nav nav-pills nav-fill">
  <?php foreach ($navs as $endpoint => $label): ?>
    <?php
      $url = wc_get_account_endpoint_url($endpoint);
      $active_class = '';
      if ($url == $current_url) {
        $active_class = 'active';
      }
    ?>
   <!-- <li class="nav-item col-md-6 col-sm-12">-->
      <!--<a class="nav-link <?php /*echo $active_class; */?>" data-toggle="pill" href="#<?php /*echo esc_url( $url ); */?> " >
        <?php /*echo $label; */?></a>-->

<!--    </li>-->
  <?php endforeach; ?>
<!--    <li class="nav-item col-md-6 col-sm-12">-->
<!--        <a class="nav-link active" data-toggle="pill" href="#oder">Oder Histoty</a>-->
<!--    </li>-->
<!--    <li class="nav-item col-md-6 col-sm-12">-->
<!--        <a class="nav-link" data-toggle="pill" href="#information">User Information</a>-->
<!--    </li>-->
</ul>




