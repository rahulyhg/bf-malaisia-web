<?php
/**
 * @package Custom
 * @version 1.0
 */
/*
 Plugin Name: Blue fox
Version: 1.0
*/

require_once 'BFOX/Autoloader.php';
new \BFOX\Export_Users;

$request_uri = trim( $_SERVER['REQUEST_URI'], '/' );
new \BFOX\Protect_Content($request_uri);

define( 'BF_CUSTOM_VERSION', '1.0' );
//$abspath = dirname( __FILE__ );
$abspath = plugin_dir_path( __FILE__ );
require_once(  $abspath . '/ajax.php');
require_once(  $abspath . '/settings.php');
require_once( $abspath . '/class-list-table.php' );
require_once( $abspath . '/export.php' );
require_once( $abspath . '/shortcodes.php' );
require_once( $abspath . '/bf-woocommerce.php' );

function bf_custom_install() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE {$wpdb->prefix}newsletter (
    id int(11) unsigned NOT NULL auto_increment,
    email varchar(100) NOT NULL DEFAULT '',
    created datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (id),
    UNIQUE KEY `email` (`email`)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option( 'bf_custom_version', BF_CUSTOM_VERSION );
}
function bf_custom_uninstall() {
    //if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )  exit();
    $option_name = 'bf_custom_version';
    delete_option( $option_name );
    // For site options in multisite
    delete_site_option( $option_name );
    //drop a custom db table
    /* global $wpdb;
    $sql = "DROP TABLE IF EXISTS {$wpdb->prefix}newsletter;";
    dbDelta( $sql ); */
}

register_activation_hook( __FILE__, 'bf_custom_install');
//register_deactivation_hook( __FILE__, 'bf_custom_uninstall');
register_uninstall_hook( __FILE__, 'bf_custom_uninstall');

if (!function_exists('bf_frontend_scripts')) {
    function bf_frontend_scripts()
    {
        wp_enqueue_style('frontend-css', plugins_url('/style.css',__FILE__), array(), null);
        wp_enqueue_script('frontend-script', plugins_url('/script.js',__FILE__), array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'bf_frontend_scripts');

add_action( 'template_redirect', 'bf_page_redirect' );
function bf_page_redirect(){
    if(!empty($_COOKIE['woocommerce_car_force_empty'])){
        global $woocommerce;
        $woocommerce->cart->empty_cart();
        $woocommerce->session->destroy_session();
        setcookie('woocommerce_car_force_empty','',time() - 99999,'/');
    }
    global $wp_query,$wp,$post;
    if(is_user_logged_in()){
        global $current_user;
        $full_name = implode(' ', array_filter(array($current_user->first_name, $current_user->last_name))) ;
        $current_user->display_name = $full_name?$full_name:$current_user->display_name;
        if(is_page_template('template-signup.php')){
            wp_redirect(home_url('my-account'));
            exit;
        }
    }elseif(is_page()){
        global $wp_query;
        //print_r($wp_query);die;
        if( in_array($wp_query->get( 'pagename', '' ),array('my-account','cart','checkout')) || strpos('[woocommerce_my_account]','bluefox'.$wp_query->queried_object->post_content) !== false ){
            wp_redirect(home_url('/').'#login');
        }
    }elseif(is_single() && $post->post_type == 'product'){
        wp_redirect(home_url('/').'#login');
    }elseif (is_archive()){
        if($wp_query->get( 'post_type', '' ) == 'product' || $wp_query->get( 'product_cat', '' ) != '')
            wp_redirect(home_url('/').'#login');
    }
}

class Blue_Fox_Plugin {
    // class instance
    static $instance;
    public $list_obj;
    private $options;
    // class constructor
    public function __construct() {
        add_filter( 'set-screen-option', array( __CLASS__, 'set_screen' ), 10, 3 );
        add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
    }
    /** Singleton instance */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public static function set_screen( $status, $option, $value ) {
        return $value;
    }

    public function plugin_menu() {

        //Add menu to level 0
        add_menu_page('Subscription',  'Subscription', 'blue_fox_dashboard', 'subscription');

        $hook = add_submenu_page( 'subscription', 'List Subscription',  'List Subscription', 'blue_fox_dashboard', 'subscription', array($this, 'custom_site_get_data_list'));
        add_action( "load-$hook", array( $this, 'screen_option'));
        $role = get_role('administrator');
        $role->add_cap('blue_fox_dashboard');
    }
    /**
     * Screen options
     */
    public function screen_option() {
        $option = 'per_page';
        $args   = array(
                'label'   => 'Number of items per page:',
                'default' => 20,
                'option'  => 'custom_site_per_page'
        );
        add_screen_option( $option, $args );
        $this->list_obj = new Custom_site_List_Table();
        if ( isset( $_POST['download']) ) {
            $data = $this->list_obj->get_all_data();
            export_csv($data);
            die();
        }
    }
    /**
     * Plugin settings page
     */
    public function custom_site_get_data_list() {
        $action = $this->list_obj->current_action();
        if($action){
            $id = !empty($_REQUEST['id'])?$_REQUEST['id']+0:0;
            if($action == 'edit' || $action == 'add' ){
                if($action == 'edit'){
                    global $wpdb;
                    $sql = "SELECT * FROM {$wpdb->prefix}{$this->list_obj->table_name} c WHERE c.id=".$id;
                    $result = $wpdb->get_results( $sql, 'ARRAY_A' );
                }
                ?>
            	<div class="wrap">
            		<h2><?php echo get_admin_page_title();?></h2>
        			    <form method="post" enctype="multipart/form-data" >
        			        <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
        			        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        			        <?php 
        			        wp_nonce_field( 'nbl_token', 'token' );
        			        ?>
                            <?php submit_button(); ?>
                        </form>
            	</div>
                <?php
            }
        }
        else{
            $this->list_obj->prepare_items();
            $add_link = add_query_arg( array( 'action' => 'add'), admin_url( 'admin.php?page='.$_REQUEST['page']) );
            ?>
        	<div class="wrap">
        		<h2><?php echo get_admin_page_title();?> <a href="<?php echo $add_link;?>" class="page-title-action">Add New</a></h2>
    			    <form method="get">
    			        <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
                        <?php $this->list_obj->search_box( __( 'Search' ), 'bf' ); ?>
                    </form>
    				<form method="post">
    					<?php
    					$this->list_obj->display(); ?>
    				</form>
        	</div>
            <?php
        }
    }
}
add_action( 'plugins_loaded', function () {
    Blue_Fox_Plugin::get_instance();
} );


function bf_get_account_fields() {
    return apply_filters( 'bf_account_fields', array(
            'user_phone'       => array(
                'type'  => 'text',
                'label' => __( 'Phone number', 'bf' ),
                'required'          => true,
                'input_class' => array('form-control input-text'),
            ),            
            'user_dob'       => array(
                'type'  => 'text',
                'label' => __( 'Day of birth', 'bf' ),
                'required'          => true,
                'input_class' => array('form-control input-text'),
                'placeholder'          => __( 'dd/mm/yyyy', 'bf' )
            )
    ) );
}

function bf_checkout_fields( $checkout_fields ) {
    $fields = bf_get_account_fields();

    foreach ( $fields as $key => $field_args ) {
        if ( ! empty( $field_args['hide_in_checkout'] ) ) {
            continue;
        }

        $checkout_fields['account'][ $key ] = $field_args;
    }

    return $checkout_fields;
}

add_filter( 'woocommerce_checkout_fields', 'bf_checkout_fields', 10, 1 );

function bf_print_user_admin_fields() {
    $fields = bf_get_account_fields();
    $user_id = get_current_user_id();
    ?>
	<h2><?php _e( 'Additional Information', 'bf' ); ?></h2>
	<table class="form-table" id="bf-additional-information">
		<tbody>
		<?php foreach ( $fields as $key => $field_args ) { 
		    if ( !empty( $field_args['hide_in_admin'] ) ) {
		        continue;
		    }
		    $value = '';
		    if ( $user_id ) {
		        $value   = get_user_meta( $user_id, $key, true );
		    }
		    ?>
			<tr>
				<th>
					<label for="<?php echo $key; ?>"><?php echo $field_args['label']; ?></label>
				</th>
				<td>
					<?php $field_args['label'] = false; ?>
					<?php woocommerce_form_field( $key, $field_args , $value); ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php
}

add_action( 'show_user_profile', 'bf_print_user_admin_fields', 30 ); // admin: edit profile
add_action( 'edit_user_profile', 'bf_print_user_admin_fields', 30 ); // admin: edit other users
/* 
function bf_add_edit_address_in_account_form(&$fields) {
    // Add billing and shipping address fields.
    $fields += [
      'billing_gender'  => ['label' => __( 'Gender', 'bf' ),
        'type' => 'radio', 'options' => ['male' => __('Male', 'bf'), 'female' => __('Female', 'bf')],
        'required' => true],
      'billing_company'  => ['label' => __( 'Company', 'bf' ), 'required' => false],
      'billing_address_1'  => ['label' => __( 'Address 1', 'bf' ), 'required' => true],
      'billing_city'  => ['label' => __( 'City', 'bf' ), 'required' => true],
      'billing_postcode'  => ['label' => __( 'Post code', 'bf' ), 'required' => false],
      'billing_country'  => ['label' => __( 'Country', 'bf' ), 'required' => false, 'type' => 'country'],
    ];
    $fields += [
      'shipping_first_name'  => ['label' => __( 'First name', 'bf' ), 'required' => true],
      'shipping_last_name'  => ['label' => __( 'Last name', 'bf' ), 'required' => true],
      'shipping_company'  => ['label' => __( 'Company', 'bf' ), 'required' => false],
      'shipping_address_1'  => ['label' => __( 'Address 1', 'bf' ), 'required' => true],
      'shipping_city'  => ['label' => __( 'City', 'bf' ), 'required' => true],
      'shipping_postcode'  => ['label' => __( 'Post code', 'bf' ), 'required' => false],
      'shipping_country'  => ['label' => __( 'Country', 'bf' ), 'required' => false, 'type' => 'country'],
    ];
}

function bf_print_user_fo_fields() {
    $fields = bf_get_account_fields();
    bf_add_edit_address_in_account_form($fields);

    $user_id = get_current_user_id();
    foreach ( $fields as $key => $field_args ) {
        if ( $user_id && ! empty( $field_args['hide_in_account'] ) ) {
            continue;
        }
        $value = ''; 
        if ( $user_id ) {
            $value   = get_user_meta( $user_id, $key, true );
        }
    		woocommerce_form_field( $key, $field_args , $value);
    }
}

add_action( 'woocommerce_edit_account_form', 'bf_print_user_fo_fields', 10 ); // my account */



function bf_validate_user_frontend_fields( $errors ) {
    $fields = bf_get_account_fields();

    foreach ( $fields as $key => $field_args ) {
        if ( empty( $field_args['required'] )
            || ($account_form && !empty( $field_args['hide_in_account'] ))) {
            continue;
        }
        if ( empty( $_POST[ $key ] ) ) {
            $message = sprintf( __( '%s is a required field.', 'bf' ), '<strong>' . strip_tags($field_args['label']) . '</strong>' );
            $errors->add( $key, $message );
        }
        if ( $key == 'user_dob' && ! preg_match('/\d{2}\/\d{2}\/\d{4}/i', $_POST['user_dob'])) {
            $message = sprintf( __( '%s is wrong format.', 'bf' ), '<strong>' . $field_args['label'] . '</strong>' );
            $errors->add( $key, $message );
        }
    }
    return $errors;
}

function bf_validate_account_form_fields($errors) {
    bf_validate_user_frontend_fields($errors);
}

//add_filter( 'woocommerce_process_registration_errors', 'bf_validate_user_frontend_fields', 10 );
add_filter( 'woocommerce_registration_errors', 'bf_validate_user_frontend_fields', 10 );
add_filter( 'woocommerce_save_account_details_errors', 'bf_validate_account_form_fields', 10 );

function bf_woocommerce_save_account_details( $user_id ) {
    $fields = bf_get_account_fields();
    
    foreach ( $fields as $key => $field_args ) {
        update_user_meta( $user_id, $key, htmlentities( $_POST[$key] ) );
    }
    
    $load_address = 'billing';
    $billing_fields = WC()->countries->get_address_fields( get_user_meta( $user_id, $load_address . '_country', true ), $load_address . '_' );
    
    $load_address = 'shipping';
    $shipping_fields = WC()->countries->get_address_fields( get_user_meta( $user_id , $load_address . '_country', true ), $load_address . '_' );
    
    $fields = $billing_fields + $shipping_fields;
    foreach ($fields as $field_name => $option){
        if(isset($_POST[$field_name] )){
            update_user_meta( $user_id, $field_name, htmlentities( $_POST[$field_name]) );
        }
    }
    // Set shipping_phone = user_phone value.
    update_user_meta( $user_id, 'billing_phone', htmlentities( $_POST['user_phone'] ) );
}
add_action( 'woocommerce_save_account_details',     'bf_woocommerce_save_account_details' );



add_filter( "option_WPLC_SETTINGS", "bf_option_wplc_settings", 10 , 2 );
function bf_option_wplc_settings($value , $option){
    if(!is_admin() || is_ajax()){
        if(!empty($value['wplc_pro_fst1'])){
            $value['wplc_pro_fst1'] = __($value['wplc_pro_fst1'],'bf');
        }
        if(!empty($value['wplc_pro_fst2'])){
            $value['wplc_pro_fst2'] = __($value['wplc_pro_fst2'],'bf');
        }
        if(!empty($value['wplc_pro_sst1'])){
            $value['wplc_pro_sst1'] = __($value['wplc_pro_sst1'],'bf');
        }
        if(!empty($value['wplc_pro_intro'])){
            $value['wplc_pro_intro'] = __($value['wplc_pro_intro'],'bf');
        }  
    }
    return $value;
}

function clear_cart_on_logout() {
    setcookie('woocommerce_car_force_empty',true,null,'/');
}
add_action('wp_logout', 'clear_cart_on_logout',10);

function bf_woe_get_order_value_billing_address($row, $order, $field){
    $billing = $order->data['billing'];
    $row = join(", ", array_filter( array( $billing["address_1"] ,  $billing["address_2"] ,  $billing["city"],  $billing["state"],  $billing["postcode"],  $billing["country"]) ) );
    return $row;
}
add_filter('woe_get_order_value_billing_address', 'bf_woe_get_order_value_billing_address',10,3);

function bf_woe_get_order_value_custom_field_1($row, $order, $field){
    $fees = $order->get_fees();
    $total = 0;
    foreach ($fees as $fee){
        $total += $fee->get_amount();
    }
    $row = $total;
    return $row;
}
add_filter('woe_get_order_value_custom_field_1', 'bf_woe_get_order_value_custom_field_1',10,3);

function bf_woe_start_export_job(){
    session_start();
    $_SESSION['export_count'] = 0;
}
add_action('woe_start_export_job','bf_woe_start_export_job',9999);

function bf_woe_get_order_value_order_number($row, $order, $field){
    @session_start();
    return ++$_SESSION['export_count'];
}
add_filter('woe_get_order_value_order_number', 'bf_woe_get_order_value_order_number',10,3);


add_action('woocommerce_checkout_process', 'bf_billing_phone_validation');

function util_phone_number_check($phone){
    return ( preg_match('/^[0]\d{9}$/', $phone) > 0 || preg_match('/^[0]\d{10}$/', $phone) > 0 );
}

function bf_billing_phone_validation() {
    // $billing_phone = filter_input(INPUT_POST, 'billing_phone');
    $billing_phone = $_POST['billing_phone'];

    // if (strlen(trim(preg_replace('/^[0]\d{10}$/', '', $billing_phone))) > 0) {
    if(!util_phone_number_check($billing_phone)){        
        wc_add_notice('<strong>' . __('Phone number you&#8217;ve just provided is not valid. It should start with 0', 'bf') . '</strong>', 'error');
    }
}
function bf_woocommerce_save_account_details_required_fields($required_fields){
    unset($required_fields['account_email']);
    return $required_fields;
}
add_filter('woocommerce_save_account_details_required_fields','bf_woocommerce_save_account_details_required_fields',10);

function bf_user_profile_update_errors($array){
    if(!empty($array->errors['empty_email'])){
        unset($array->errors['empty_email'],$array->error_data['empty_email']);
    }
}
add_action('user_profile_update_errors', 'bf_user_profile_update_errors',9999);

function bf_woocommerce_checkout_posted_data($data){
    $data['billing_country'] = 'VN';
    return $data;
}
add_filter('woocommerce_checkout_posted_data', 'bf_woocommerce_checkout_posted_data',999);

function bf_export_user_filter() {
    static $renderd = false;
    if(!$renderd){
        echo '<input type="submit" name="btn_export" class="button" value="Export user to csv">';
        $renderd = true;
    }
}
add_action( 'restrict_manage_users', 'bf_export_user_filter' );
add_action("init",'export_user_2_csv');

/* Game 3 settings */

add_action('admin_menu', 'admin_menu_game4_settings_menu');

function admin_menu_game4_settings_menu()
{

    global $menu;

    add_menu_page(
        __('Game 4 settings', 'default'),
        __('Game 4 settings', 'default'),
        'manage_options',
        'game4_settings',
        'admin_menu_game4_settings_callback',
        false,
        '90'
    );

    acf_add_options_sub_page(array(
        'page_title' 	=> __('Game content', 'bf-backend'),
        'menu_title'	=> __('Game 4 general settings', 'bf-backend'),
        'parent_slug'	=> 'game4_settings',
        'capability' 	=> 'manage_options',
        'position' => false,
    ));
}

function admin_menu_game4_settings_callback()
{
    $view_vars = array();
    // load data
    $data_game_json = stripslashes( get_option('game4_data') );
    $data_game = empty($data_game_json)? array() : json_decode($data_game_json);

    // handle events
    $is_submit_form = isset($_POST['is_submit_form']);
    $is_delete = isset($_POST['is_delete']);

    $arrGame = [];
    foreach ($data_game as $game){
        array_push($arrGame,  $game->word);
    }

    if($is_submit_form){
        // get data from post
        $word = $_POST['word'];
        if(!in_array($word,$arrGame)){
            $chars = $_POST['chars'];
            $id = md5($word);
            array_push($data_game,array(
                'id' => $id,
                'word' => $word,
                'chars' => $chars
            ));
            $data_game_json = wp_json_encode($data_game);
            update_option('game4_data', $data_game_json);
        }
    }
    
    if($is_delete){
        $new_data_game = array();
        $word_id= $_POST['word_id'];
        
        foreach ($data_game as $word){
            $w = empty($word->id) ? $word['id'] : $word->id ;
            if($w !== $word_id){
                array_push($new_data_game, $word);
            }
        }
        $data_game = $new_data_game;
        $data_game_json = wp_json_encode($data_game);
        update_option('game4_data', $data_game_json);
    }

    $view_vars['data_game'] = $data_game;

    // load view
    load_view('game4_settings', $view_vars);
}

function load_view($view, $data = array())
{
    ob_start();
    extract($data);
    include "views/$view.php";
    echo ob_get_clean();
}
