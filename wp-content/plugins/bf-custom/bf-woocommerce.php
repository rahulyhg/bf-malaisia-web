<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

include 'cities/tinh_thanhpho.php';

add_action( 'plugins_loaded', array( 'BF_Woocommerce_Class', 'init' ) );
class BF_Woocommerce_Class
{
    protected static $instance;

	protected $_version = '1.0.5';
	public $_optionName = 'devvn_woo_district';
	public $_optionGroup = 'devvn-district-options-group';
	public $_defaultOptions = array(
	    'active_village'	            =>	'',
        'required_village'	            =>	'',
        'to_vnd'	                    =>	'',
        'remove_methob_title'	        =>	'',
        'freeship_remove_other_methob'  =>  '',
        'khoiluong_quydoi'  =>  '6000',
        'tinhthanh_default'  =>  '79',
        'active_vnd2usd'    =>  0,
        'vnd_usd_rate'          =>  '22745',
        'vnd2usd_currency'          =>  'USD',

        'alepay_support'                =>  0
	);

    public static function init(){
        is_null( self::$instance ) AND self::$instance = new self;
        return self::$instance;
    }

	public function __construct(){
	    add_filter( 'woocommerce_billing_fields' , array($this, 'custom_override_billing_fields'), 99999 );
	    add_filter( 'woocommerce_shipping_fields' , array($this, 'custom_override_shipping_fields'), 99999 );
	    add_filter( 'woocommerce_admin_billing_fields' , array($this, 'custom_override_admin_order_billing_fields'), 99999 );
	    add_filter( 'woocommerce_admin_shipping_fields' , array($this, 'custom_override_admin_order_shipping_fields'), 99999 );
	    
        
        
        
        
        add_filter( 'woocommerce_customer_meta_fields' , array($this, 'custom_overwrite_customer_meta_fields'), 99999 );
        
        add_filter('woe_get_order_value_billing_address_2', array($this, 'custom_override_order_value_billing_address_2'),99999,3);
        add_filter('woe_get_order_value_billing_city', array($this, 'custom_override_order_value_billing_city'),99999,3);
        add_filter('woe_get_order_value_billing_state', array($this, 'custom_override_order_value_billing_state'),99999,3);
        
        add_filter( 'woocommerce_states', array($this, 'vietnam_cities_woocommerce'), 9999 );
        add_filter('woocommerce_get_country_locale', array($this, 'devvn_woocommerce_get_country_locale'), 99);
        
        add_action( 'wp_enqueue_scripts', array($this, 'devvn_enqueue_UseAjaxInWp') );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        
        add_action( 'wp_ajax_load_diagioihanhchinh', array($this, 'load_diagioihanhchinh_func') );
        add_action( 'wp_ajax_nopriv_load_diagioihanhchinh', array($this, 'load_diagioihanhchinh_func') );
        
        add_filter('woocommerce_localisation_address_formats', array($this, 'devvn_woocommerce_localisation_address_formats') );
        add_filter('woocommerce_order_formatted_billing_address', array($this, 'devvn_woocommerce_order_formatted_billing_address'), 10, 2);
        
        add_action( 'woocommerce_admin_order_data_after_shipping_address', array($this, 'devvn_after_shipping_address'), 10, 1 );
        add_filter('woocommerce_order_formatted_shipping_address', array($this, 'devvn_woocommerce_order_formatted_shipping_address'), 10, 2);
        
        add_filter('woocommerce_order_details_after_customer_details', array($this, 'devvn_woocommerce_order_details_after_customer_details'), 10);
        
        //my account
        add_filter('woocommerce_my_account_my_address_formatted_address',array($this, 'devvn_woocommerce_my_account_my_address_formatted_address'),10,3);
        
        //More action
        add_filter( 'default_checkout_billing_country', array($this, 'devvn_change_default_checkout_country'), 99 );
        add_filter( 'default_checkout_billing_state', array($this, 'devvn_change_default_checkout_state'), 99 );
        
        //Options
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'plugin_action_links' ) );
        
        add_option( $this->_optionName, $this->_defaultOptions );
    }


	function vietnam_cities_woocommerce( $states ) {
		global $tinh_thanhpho;
	  	$states['VN'] = $tinh_thanhpho;
	  	return $states;
	}
	
	function custom_override_order_value_billing_address_2($row, $order, $field){
	    $billing = $order->data['billing'];
	    $val = $this->get_name_village($billing["address_2"]) ;
	    return  ($val?$val:$row);
	}
	
	function custom_override_order_value_billing_city($row, $order, $field){
	    $billing = $order->data['billing'];
	    $val = $this->get_name_district($billing["city"]);
	    return  ($val?$val:$row);
	}
	
	function custom_override_order_value_billing_state($row, $order, $field){
	    $billing = $order->data['billing'];
	    $val = $this->get_name_city($billing["state"]) ;
	    return  ($val?$val:$row);
	}
	
	function custom_overwrite_customer_meta_fields( $fields ) { 
	    $user_id = empty($_GET['user_id'])?0:(int) $_GET['user_id'];
	    $current_user = wp_get_current_user();
	    if ( ! $user_id && $current_user)
	    $user_id = $current_user->ID;
	    
	    
	    $fields['billing']['fields'] = $this->custom_override_billing_fields($fields['billing']['fields']);
	    foreach ($fields['billing']['fields'] as $key => $val){
	        if(is_array($val['class'])){
	            $fields['billing']['fields'][$key]['class'] = implode(' ', $val['class']);
	        }
	    }
	    $user_temp = get_userdata( $user_id );
	    if($user_temp->billing_state){
	        foreach ($this->get_list_district($user_temp->billing_state) as $item)
	            $fields['billing']['fields']['billing_city']['options'][$item['maqh']] = $item['name'];
	    }
	    if($user_temp->billing_city){
	        foreach ($this->get_list_village($user_temp->billing_city) as $item)
	            $fields['billing']['fields']['billing_address_2']['options'][$item['xaid']] = $item['name'];
	    }

	    
	    $fields['shipping']['fields'] = $this->custom_override_shipping_fields($fields['shipping']['fields']);
	    foreach ($fields['shipping']['fields'] as $key => $val){
	        if(is_array($val['class'])){
	            $fields['shipping']['fields'][$key]['class'] = implode(' ', $val['class']);
	        }
	    }
	    
	    if($user_temp->shipping_state){
	        foreach ($this->get_list_district($user_temp->shipping_state) as $item)
	            $fields['shipping']['fields']['shipping_city']['options'][$item['maqh']] = $item['name'];
	    }
	    if($user_temp->shipping_city){
	        foreach ($this->get_list_village($user_temp->shipping_city) as $item)
	            $fields['shipping']['fields']['shipping_address_2']['options'][$item['xaid']] = $item['name'];
	    }
	    
	    
	    return $fields;
	}
	
	function custom_override_admin_order_billing_fields( $fields ) {
	    $fields = $this->custom_override_admin_order_fields( $fields );
	    return $fields;
	}
	function custom_override_admin_order_shipping_fields( $fields ) {
	    $fields =  $this->custom_override_admin_order_fields( $fields,'shipping' );
	    return $fields;
	}
	
	function custom_override_admin_order_fields( $fields , $field_name = 'billing' ) {
	    global $tinh_thanhpho;
	    //unset($fields['country']);
	    $fields['state']['options']   	= $tinh_thanhpho;
	    $fields['city']['options'] = array('');
	    $fields['address_2']['options'] = array('');
	    
	    $fields['address_2']['type']    = 'select';
	    $fields['city']['type']    = 'select';
	    $fields['state']['type']    = 'select';
	    
	    global $theorder;
	    if ( ! is_object( $theorder ) ) {
	        $theorder = wc_get_order( $_GET['post'] );
	    }
	    $order = $theorder;
	    if(is_object($order)){
    	    $state = $order->{"get_".$field_name."_state"}();
    	    if($state){
    	        foreach ($this->get_list_district($state) as $item)
    	            $fields['city']['options'][$item['maqh']] = $item['name'];
    	    }
    	    $city = $order->{"get_".$field_name."_city"}();
    	    if($city){
    	        foreach ($this->get_list_village($city) as $item)
    	            $fields['address_2']['options'][$item['xaid']] = $item['name'];
    	    }
	   }
	    return $fields;
	}
	
	function custom_override_billing_fields( $fields ) {
	    global $tinh_thanhpho;
        $fields['billing_state'] = array(
            'label'			=> __('Province/City', 'bf'),
            'required' 		=> true,
            'type'			=> 'select',
            'class'    		=> array( 'form-row-wide', 'address-field-state', 'update_totals_on_change' ),
            'placeholder'	=> _x('Select Province/City', 'placeholder', 'bf'),
            'options'   	=> $tinh_thanhpho,
            'priority'  =>  30
        );
        $fields['billing_city'] = array(
            'label'		=> __('District', 'bf'),
            'required' 	=> true,
            'type'		=>	'select',
            'class'    	=> array( 'form-row-wide', 'address-field-city', 'update_totals_on_change' ),
            'placeholder'	=>	_x('Select District', 'placeholder', 'bf'),
            'options'   => array(
                ''	=> ''
            ),
            'priority'  =>  40
        );
        
        $fields['billing_address_2'] = array(
            'label' => __('Commune/Ward/Town', 'bf'),
            'required' => true,
            'type' => 'select',
            'class' => array('form-row-wide', 'address-field-ward', 'update_totals_on_change'),
            'placeholder' => _x('Select Commune/Ward/Town', 'placeholder', 'bf'),
            'options' => array(
                '' => ''
            ),
            'priority'  =>  50
        );
        $fields['billing_address_1']['placeholder'] = _x('Ex: No. 20, 90 Alley', 'placeholder', 'bf');
        $fields['billing_address_1']['class'] = array('form-row-wide');
    
        $fields['billing_address_1']['priority']  = 28;
        
        
        if(isset($fields['billing_postcode'])) {
            $fields['billing_postcode']['priority'] = 50;
        }
        
        if(isset($fields['billing_phone'])) {
            $fields['billing_phone']['priority'] = 51;
        }
        if(isset($fields['billing_email'])) {
            $fields['billing_email']['priority'] = 52;
        }
        $fields['billing_postcode']['required'] = false;
        unset($fields['billing_country']);
        unset($fields['billing_company']);
        uasort( $fields, array( $this, 'sort_fields_by_order' ) );
	    return $fields;
	}
	
    function custom_override_shipping_fields( $fields ) {
        global $tinh_thanhpho;
        //Shipping
        $fields['shipping_phone'] = array(
            'label' => __('Phone', 'bf'),
            'placeholder' => _x('Phone', 'placeholder', 'bf'),
            'required' => false,
            'class' => array('form-row-wide'),
            'clear' => true,
            'priority'  =>  51
        );
        $fields['shipping_state'] = array(
            'label'		=> __('Province/City', 'bf'),
            'required' 	=> true,
            'type'		=>	'select',
            'class'    	=> array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
            'placeholder'	=>	_x('Select Province/City', 'placeholder', 'bf'),
            'options'   => $tinh_thanhpho,
            'priority'  =>  30
        );
        $fields['shipping_city'] = array(
            'label'		=> __('District', 'bf'),
            'required' 	=> true,
            'type'		=>	'select',
            'class'    	=> array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
            'placeholder'	=>	_x('Select District', 'placeholder', 'bf'),
            'options'   => array(
                ''	=> '',
            ),
            'priority'  =>  40
        );
        $fields['shipping_address_2'] = array(
            'label' => __('Commune/Ward/Town', 'bf'),
            'required' => true,
            'type' => 'select',
            'class' => array('form-row-wide', 'address-field', 'update_totals_on_change'),
            'placeholder' => _x('Select Commune/Ward/Town', 'placeholder', 'bf'),
            'options' => array(
                '' => '',
            ),
            'priority'  =>  50
        );
        $fields['shipping_address_1']['placeholder'] = _x('Ex: No. 20, 90 Alley', 'placeholder', 'bf');
        $fields['shipping_address_1']['priority']  = 60;
        $fields['shipping_address_1']['class']  = array('form-row-wide');

        unset($fields['shipping_country']);
        unset($fields['shipping_company']);

        
        uasort( $fields, array( $this, 'sort_fields_by_order' ) );
        return $fields;
    }

    function sort_fields_by_order($a, $b){
        if(!isset($a['priority']) || $a['priority'] == $b['priority']){
            return 0;
        }
        return ($a['priority'] < $b['priority']) ? -1 : 1;
    }


	function search_in_array($array, $key, $value)
	{
	    $results = array();

	    if (is_array($array)) {
            if (isset($array[$key]) && is_numeric($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }elseif(isset($array[$key]) && is_serialized($array[$key]) && in_array($value,maybe_unserialize($array[$key]))){
                $results[] = $array;
            }
	        foreach ($array as $subarray) {
	            $results = array_merge($results, $this->search_in_array($subarray, $key, $value));
	        }
	    }

	    return $results;
	}

	function devvn_enqueue_UseAjaxInWp() {
	  global $wp;
		if(is_checkout() || $wp->request == 'my-account' ){
        wp_enqueue_style( 'dwas_styles', plugins_url( '/assets/css/devvn_dwas_style.css', __FILE__ ), array(), $this->_version, 'all' );
        wp_enqueue_script( 'devvn_tinhthanhpho', plugins_url('assets/js/devvn_tinhthanh.js', __FILE__), array('jquery','select2'), $this->_version, true);
		}
		$php_array = array(
		        'admin_ajax'		=>	admin_url( 'admin-ajax.php'),
		        'home_url'			=>	home_url(),
		        'formatNoMatches'   =>  __('No value', 'bf')
		);
		wp_localize_script( 'devvn_tinhthanhpho', 'devvn_array', $php_array );
	}

	function load_diagioihanhchinh_func() {
		$matp = isset($_POST['matp']) ? intval($_POST['matp']) : '';
		$maqh = isset($_POST['maqh']) ? intval($_POST['maqh']) : '';
		if($matp){
			$result = $this->get_list_district($matp);
			wp_send_json_success($result);
		}
		if($maqh){
			$result = $this->get_list_village($maqh);
			wp_send_json_success($result);
		}
		wp_send_json_error();
		die();
	}
	function devvn_get_name_location($arg = array(), $id = '', $key = ''){
		if(is_array($arg) && !empty($arg)){
			$nameQuan = $this->search_in_array($arg,$key,$id);
			$nameQuan = isset($nameQuan[0]['name'])?$nameQuan[0]['name']:'';
			return $nameQuan;
		}
		return false;
	}

	function get_name_city($id = ''){
		global $tinh_thanhpho;
		if(!is_array($tinh_thanhpho) || empty($tinh_thanhpho)){
			include 'cities/tinh_thanhpho.php';
		}
		$id_tinh = sprintf("%02d", intval($id));
		return (isset($tinh_thanhpho[$id_tinh]))?$tinh_thanhpho[$id_tinh]:'';
	}

	function get_name_district($id = ''){
		include 'cities/quan_huyen.php';
		$id_quan = sprintf("%03d", intval($id));
		if(is_array($quan_huyen) && !empty($quan_huyen)){
			$nameQuan = $this->search_in_array($quan_huyen,'maqh',$id_quan);
			$nameQuan = isset($nameQuan[0]['name'])?$nameQuan[0]['name']:'';
			return $nameQuan;
		}
		return false;
	}

	function get_name_village($id = ''){
		include 'cities/xa_phuong_thitran.php';
		$id_xa = sprintf("%05d", intval($id));
		if(is_array($xa_phuong_thitran) && !empty($xa_phuong_thitran)){
			$name = $this->search_in_array($xa_phuong_thitran,'xaid',$id_xa);
			$name = isset($name[0]['name'])?$name[0]['name']:'';
			return $name;
		}
		return false;
	}

	function devvn_woocommerce_localisation_address_formats($arg){
		unset($arg['default']);
		unset($arg['VN']);
		$arg['default'] = "{name}\n{company}\n{address_1}\n{address_2}\n{city}\n{state}\n{country}";
		$arg['VN'] = "{name}\n{company}\n{address_1}\n{address_2}\n{city}\n{state}\n{country}";
		return $arg;
	}

	function devvn_woocommerce_order_formatted_billing_address($eArg,$eThis){

        if($this->devvn_check_woo_version()){
            $orderID = $eThis->get_id();
        }else {
            $orderID = $eThis->id;
        }

		$nameTinh = $this->get_name_city(get_post_meta( $orderID, '_billing_state', true ));
		$nameQuan = $this->get_name_district(get_post_meta( $orderID, '_billing_city', true ));
		$nameXa = $this->get_name_village(get_post_meta( $orderID, '_billing_address_2', true ));

		unset($eArg['state']);
		unset($eArg['city']);
		unset($eArg['address_2']);

		$eArg['state'] = $nameTinh;
		$eArg['city'] = $nameQuan;
		$eArg['address_2'] = $nameXa;

		return $eArg;
	}

	function devvn_woocommerce_order_formatted_shipping_address($eArg,$eThis){

        if($this->devvn_check_woo_version()){
            $orderID = $eThis->get_id();
        }else {
            $orderID = $eThis->id;
        }

		$nameTinh = $this->get_name_city(get_post_meta( $orderID, '_shipping_state', true ));
		$nameQuan = $this->get_name_district(get_post_meta( $orderID, '_shipping_city', true ));
		$nameXa = $this->get_name_village(get_post_meta( $orderID, '_shipping_address_2', true ));

		unset($eArg['state']);
		unset($eArg['city']);
		unset($eArg['address_2']);

		$eArg['state'] = $nameTinh;
		$eArg['city'] = $nameQuan;
		$eArg['address_2'] = $nameXa;

		return $eArg;
	}

	function devvn_woocommerce_my_account_my_address_formatted_address($args, $customer_id, $name){

		$nameTinh = $this->get_name_city(get_user_meta( $customer_id, $name.'_state', true ));
		$nameQuan = $this->get_name_district(get_user_meta( $customer_id, $name.'_city', true ));
		$nameXa = $this->get_name_village(get_user_meta( $customer_id, $name.'_address_2', true ));

		// unset($args['first_name']);
		unset($args['company']);
		unset($args['address_2']);
		unset($args['city']);
		unset($args['state']);

		$args['state'] = $nameTinh;
		$args['city'] = $nameQuan;
		$args['address_2'] = $nameXa;

		return $args;
	}

	function get_list_district($matp = ''){
		if(!$matp) return false;
		include 'cities/quan_huyen.php';
		$matp = sprintf("%02d", intval($matp));
		$result = $this->search_in_array($quan_huyen,'matp',$matp);
		return $result;
	}

    function get_list_district_select($matp = ''){
        $district_select  = array();
        $district_select_array = $this->get_list_district($matp);
        if($district_select_array && is_array($district_select_array)){
            foreach ($district_select_array as $district){
                $district_select[$district['maqh']] = $district['name'];
            }
        }
        return $district_select;
    }

	function get_list_village($maqh = ''){
		if(!$maqh) return false;
		include 'cities/xa_phuong_thitran.php';
		$id_xa = sprintf("%05d", intval($maqh));
		$result = $this->search_in_array($xa_phuong_thitran,'maqh',$id_xa);
		return $result;
	}

    function get_list_village_select($maqh = ''){
        $village_select  = array();
        $village_select_array = $this->get_list_village($maqh);
        if($village_select_array && is_array($village_select_array)){
            foreach ($village_select_array as $village){
                $village_select[$village['xaid']] = $village['name'];
            }
        }
        return $village_select;
    }

	function devvn_after_shipping_address($order){
	    if($this->devvn_check_woo_version()){
            $orderID = $order->get_id();
        }else {
            $orderID = $order->id;
        }
	    echo '<p><strong>'.__('Phone number of the recipient', 'bf').':</strong> <br>' . get_post_meta( $orderID, '_shipping_phone', true ) . '</p>';
	}

	function devvn_woocommerce_order_details_after_customer_details($order){
		ob_start();
        if($this->devvn_check_woo_version()){
            $orderID = $order->get_id();
        }else {
            $orderID = $order->id;
        }
        $sdtnguoinhan = get_post_meta( $orderID, '_shipping_phone', true );
		if ( $sdtnguoinhan ) : ?>
			<tr>
				<th><?php _e( 'Shipping Phone:', 'bf' ); ?></th>
				<td><?php echo esc_html( $sdtnguoinhan ); ?></td>
			</tr>
		<?php endif;
		echo ob_get_clean();
	}

	public function get_options($option = 'active_village'){
		$flra_options = wp_parse_args(get_option($this->_optionName),$this->_defaultOptions);
		return isset($flra_options[$option])?$flra_options[$option]:false;
	}

	public function admin_enqueue_scripts() {
        wp_enqueue_style( 'woocommerce_district_shipping_styles', plugins_url( '/assets/css/admin.css', __FILE__ ), array(), $this->_version, 'all' );
        wp_enqueue_script( 'woocommerce_district_admin_order', plugins_url( '/assets/js/admin-district-admin-order.js', __FILE__ ), array( 'jquery', 'select2'), $this->_version, true );
        wp_enqueue_script( 'devvn_tinhthanhpho', plugins_url('assets/js/devvn_tinhthanh.js', __FILE__), array('jquery','select2'), $this->_version, true);
        
        $php_array = array(
                'admin_ajax'		=>	admin_url( 'admin-ajax.php'),
                'home_url'			=>	home_url(),
                'formatNoMatches'   =>  __('No value', 'bf')
        );
        wp_localize_script( 'woocommerce_district_admin_order', 'devvn_array', $php_array ); 
	}

    public static function plugin_action_links( $links ) {
        $action_links = array(
            'upgrade_pro' => '<a href="http://levantoan.com/plugin-tinh-phi-van-chuyen-cho-quan-huyen-trong-woocommerce/"  target="_blank" style="color: #e64a19; font-weight: bold; font-size: 108%%;" title="' . esc_attr( __( 'Upgrade to Pro', 'bf' ) ) . '">' . __( 'Upgrade to Pro', 'bf' ) . '</a>',
            'settings' => '<a href="' . admin_url( 'options-general.php?page=devvn-district-address' ) . '" title="' . esc_attr( __( 'Settings', 'bf' ) ) . '">' . __( 'Settings', 'bf' ) . '</a>',
        );

        return array_merge( $action_links, $links );
    }
    public function devvn_check_woo_version($version = '3.0.0'){
        if ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, $version, '>=' ) ) {
            return true;
        }
        return false;
    }
    function devvn_change_default_checkout_country() {
        return 'VN';
    }
    function devvn_change_default_checkout_state() {
        $state = $this->get_options('tinhthanh_default');
        return ($state)?$state:'79';
    }

    function devvn_woocommerce_get_country_locale($args){
        $args['VN'] = array(
            'state' => array(
                'label'        => __('Province/City', 'devvn-ghtk'),
                'priority'     => 41,
            ),
            'city' => array(
                'priority'     => 42,
            ),
            'address_2' => array(
                'hidden'   => false,
                'priority'     => 43,
            ),
            'address_1' => array(
                'priority'     => 44,
            ),
        );
        return $args;
    }
}
}//End if active woo