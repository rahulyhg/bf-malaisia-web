<?php
add_action( 'init', 'bzn_register_menus' );
function bzn_register_menus() { 
    register_nav_menus(
        array(  
          'main_menu' => __("Main Menu"),
          'footer_menu' => __("Footer Menu")
        )
    );

    init_main_menu();
    init_footer_menu();
}

function init_main_menu(){  
  $items = array(
    array('title' => 'Prizes', 'url' => site_url('prizes'), 'classes' => 'prizes'),
    array('title' => 'Winners', 'url' => site_url('winners'), 'classes' => 'winners'),
    array('title' => 'Our brand', 'url' => site_url('our-brand'), 'classes' => 'our-brand'),
    array('title' => 'Products', 'url' => site_url('shop'), 'classes' => 'products'),
    array('title' => 'My Carts', 'url' => site_url('cart'), 'classes' => 'my-carts'),
    array('title' => 'Login', 'url' => site_url('login'), 'classes' => 'login'),
  );
  init_new_menu('main_menu', $items, false);
}

function init_footer_menu(){
  $items = array(
    array('title' => 'Customer services', 'url' => site_url('customer-services'), 'classes' => 'customer-services'),
    array('title' => 'Terms & Conditions', 'url' => site_url('terms-and-conditions'), 'classes' => 'terms'),
    array('title' => 'FAQ', 'url' => site_url('faq'), 'classes' => 'faq'),
    array('title' => 'Contact information', 'url' => site_url('contact'), 'classes' => 'contact')
  );
  init_new_menu('footer_menu', $items, false);  
}

function init_new_menu($menu_slug , $items = array(), $test = false){
    // Init menu_topnav
    $menu_exists = wp_get_nav_menu_object( $menu_slug );
    if( !$menu_exists){
        $menu_id = wp_create_nav_menu( $menu_slug );        
        foreach($items as $item){
          wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  $item['title'],            
            'menu-item-url' => $item['url'],
            'menu-item-classes' => $item['classes'], 
            'menu-item-status' => 'publish',
          ));        
        }        
        if($test){
          // creating test sub menu
          $item = array('title' => 'Test Item', 'url' => '#', 'classes' => '');
          $menu_item_parent_id = wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' =>  $item['title'],            
            'menu-item-url' => $item['url'],
            'menu-item-classes' => $item['classes'], 
            'menu-item-status' => 'publish',
          ));
          // create childs
          foreach($items as $item){
            wp_update_nav_menu_item($menu_id, 0, array(
              'menu-item-title' =>  $item['title'],            
              'menu-item-url' => $item['url'],
              'menu-item-classes' => $item['classes'], 
              'menu-item-status' => 'publish',
              'menu-item-parent-id' => $menu_item_parent_id
            ));        
          }          
        }
    
        if(!has_nav_menu($menu_slug)){
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$menu_slug] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }    
}