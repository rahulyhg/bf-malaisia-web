<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront-child
 */
get_template_part('parts/head');
?> 
    <header id="page-header">
      <nav class="bf-navbar">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 clearfix">
              <div class="bf-navbar-menu-head">                
                <a id="navbar-menu-toggle">Menu</a>
                <a id="navbar-logo" href="<?php echo home_url(); ?>"></a>
                <?php if(!is_user_logged_in()): ?>
                  <a id="navbar-login" class="dialog-trigger" href="javascript:void(0);" data-target="#modal-login-form"><?php echo __('Login'); ?></a>
                <?php endif;?>
                <a href="<?php echo home_url('cart'); ?>" id="navbar-cart"></a>         
              </div>
              <!-- begin -->
              <div class="bf-navbar-content">
                <div class="bf-navbar-menu" id="bf-navbar-menu">
                  <div class="navbar-menu-close-wrapper">
                    <a id="navbar-menu-close"></a>
                  </div>            
                  <?php 
                  $menu_items = wp_get_nav_menu_items('main_menu'); 
                  global $wp;
                  $curr_link = home_url($wp->request);
                  foreach($menu_items as $menu_item) : 
                      if(!is_front_page() && strpos($menu_item->url, $curr_link) >-1 ){
                          $menu_item->classes[] = 'current-link';
                      }
                  ?>
                    <?php if(in_array('products', $menu_item->classes) && !is_user_logged_in()): ?>
                      <a class="bf-navbar-link bf-navbar-link-deactive clearfix <?php echo implode(' ', $menu_item->classes);  ?>" href="javascript:void(0);">
                        <?php echo $menu_item->title; ?>
                      </a>
                    <?php elseif(in_array('login', $menu_item->classes)): ?>
                      <?php if(is_user_logged_in()): ?>
                        <a class="bf-navbar-link clearfix" href="<?php echo home_url('my-account'); ?>">
                          <?php echo __('My Profile'); ?>
                        </a>                    
                      <?php else: ?>
                        <a class="bf-navbar-link dialog-trigger clearfix <?php echo implode(' ', $menu_item->classes);  ?>" href="javascript:void(0);" data-target="#modal-login-form">
                          <?php echo $menu_item->title; ?>
                        </a>                        
                      <?php endif; ?>                   
                    <?php else : 
                            if(in_array('my-carts',$menu_item->classes) && !is_user_logged_in()){
                                $menu_item->classes[] = 'bf-navbar-link-deactive';
                            }
                    ?>
                      <a class="bf-navbar-link clearfix <?php echo implode(' ', $menu_item->classes);  ?>" href="<?php echo $menu_item->url; ?>">
                        <?php echo $menu_item->title; ?>
                        <?php if(in_array('my-carts',$menu_item->classes)): ?>
                          <span class="my-cart-items-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                          <div class="cart-hidden hidden"></div>  
                        <?php endif; ?>
                      </a>
                    <?php endif; ?>
                  <?php endforeach; ?>                      
                </div>
              </div>              
              <!-- end -->
            </div>
          </div>
        </div>        
      </nav>
    </header>

    <main id="page-content">