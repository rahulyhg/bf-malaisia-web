<?php
add_action('acf/init', 'bf_acf_init');

function bf_acf_init() {
	if( function_exists('acf_add_options_page') ) {
		$parent = acf_add_options_page(array(
			'page_title' 	=> __('Blue Fox Settings', 'bf-backend'),
			'menu_title' 	=> __('Blue Fox Settings', 'bf-backend'),
			'menu_slug' 	=> 'bf-settings',
		  'parent_slug'	=> '',
      'capability' 	=> 'manage_options',
		  'position' => false,
      //'redirect' 	=> false 
		));
		acf_add_options_sub_page(array(
    		'page_title' 	=> __('General', 'bf-backend'),
    		'menu_title'	=> __('General settings', 'bf-backend'),
    		'parent_slug'	=> $parent['menu_slug'],
    		'capability' 	=> 'manage_options',
    		'position' => false,
		));
		acf_add_options_sub_page(array(
    		'page_title' 	=> __('Manage popup content', 'bf-backend'),
    		'menu_title'	=> __('Popup settings', 'bf-backend'),
    		'parent_slug'	=> $parent['menu_slug'],
    		'capability' 	=> 'manage_options',
    		'position' => false,
		));
		// acf_add_options_sub_page(array(
    	// 	'page_title' 	=> __('Game content', 'bf-backend'),
    	// 	'menu_title'	=> __('Game settings', 'bf-backend'),
    	// 	'parent_slug'	=> $parent['menu_slug'],
    	// 	'capability' 	=> 'manage_options',
    	// 	'position' => false,
		// ));
		acf_add_options_sub_page(array(
    		'page_title' 	=> __('Game content', 'bf-backend'),
    		'menu_title'	=> __('Game 1 settings', 'bf-backend'),
    		'parent_slug'	=> $parent['menu_slug'],
    		'capability' 	=> 'manage_options',
    		'position' => false,
		));
		acf_add_options_sub_page(array(
    		'page_title' 	=> __('Game content', 'bf-backend'),
    		'menu_title'	=> __('Game 3 settings(Wheel)', 'bf-backend'),
    		'parent_slug'	=> $parent['menu_slug'],
    		'capability' 	=> 'manage_options',
    		'position' => false,
		));				
        acf_add_options_sub_page(array(
            'page_title' 	=> __('Game content', 'bf-backend'),
            'menu_title'	=> __('Game 5 settings', 'bf-backend'),
            'parent_slug'	=> $parent['menu_slug'],
            'capability' 	=> 'manage_options',
            'position' => false,
        ));
        acf_add_options_sub_page(array(
            'page_title' 	=> __('Game content', 'bf-backend'),
            'menu_title'	=> __('Game 2 settings', 'bf-backend'),
            'parent_slug'	=> $parent['menu_slug'],
            'capability' 	=> 'manage_options',
            'position' => false,
		));
        acf_add_options_sub_page(array(
            'page_title' 	=> __('Game content', 'bf-backend'),
            'menu_title'	=> __('Sign Up Flow Settings', 'bf-backend'),
            'parent_slug'	=> $parent['menu_slug'],
            'capability' 	=> 'manage_options',
            'position' => false,
        ));		
	}
}