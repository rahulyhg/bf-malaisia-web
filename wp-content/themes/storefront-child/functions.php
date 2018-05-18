<?php
ini_set('session.cookie_httponly', 1);

add_action( 'user_register', 'attact_campaign_id_with_user' );
function attact_campaign_id_with_user($user_id) {
	$campaign_id = isset($_COOKIE['bf-campaignid']) ? $_COOKIE['bf-campaignid'] : '';
	update_user_meta($user_id, 'campaign_id', $campaign_id);
}

add_action('woocommerce_checkout_create_order', 'before_checkout_create_order', 20, 2);
function before_checkout_create_order( $order, $data ) {
	$campaign_id = isset($_COOKIE['bf-campaignid']) ? $_COOKIE['bf-campaignid'] : '';
	$order->update_meta_data( 'campaign_id', $campaign_id );
	$cookie_name = 'bf-campaignid';
	unset($_COOKIE[$cookie_name]);
	setcookie($cookie_name, '', time() - 3600);
}

$req = $_REQUEST;
if (key_exists('campaignid', $req)) {
	$cookie_name = "bf-campaignid";
	$cookie_value = $req['campaignid'];
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function child_theme_assets($path = '', $return = false)
{
    if($return) return get_bloginfo('template_url') . "-child/$path";
    // else
    echo get_bloginfo('template_url') . "-child/$path";
}
$wp_theme_dir		 = esc_url( get_theme_file_uri() );
$wp_assets_dir		 = $wp_theme_dir.'/assets/';
$path = $wp_theme_dir;
$bf_upload_url = content_url() . '/themes/storefront-child';
/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
#add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */


/**
 * Enqueue scripts and styles.
 */
function bs_scripts() {

    global $path;
/*    $scripts = array(
        '/js/index.min.js'
    );

    foreach ( $scripts as $key => $url ) {
        wp_enqueue_script( 'bs-script-' . $key, $path . $url, array() );
    }*/

    // Localize the script with new data
    $site_params = array(
        'url' => get_bloginfo('url')
    );
    wp_localize_script( 'bs-script', 'site_params', $site_params );
    wp_enqueue_script('js-cookie', $path. '/js/js.cookie.js', array(), null, true);
    wp_enqueue_script('bs-script', $path. '/js/index.min.js', array(), null, true);

    $styles = array(
        '/jquery-ui.css'
    );

    foreach ( $styles as $key => $url ) {
        wp_enqueue_style( 'bs-style-' . $key, $path . $url, array() );
    }

}

add_action( 'wp_enqueue_scripts', 'bs_scripts' );

/**
 * Modify get list products.
 *
 * @param  [type] $query [description]
 * @return [type]        [description]
 */
function bf_get_list_post($query) {
    if ( !$query->is_main_query() || is_singular() || is_404() || is_admin()) {
        return ;
    }

    // Product list.
    if( is_post_type_archive('product') || is_product_category() ) {
        $query->set( 'posts_per_page', 8 );
    }

    // Winner, video list.
    if(is_post_type_archive('winner') || is_post_type_archive('video')) {
        $query->set( 'posts_per_page', 6 );

        // Sort by title for list-winner archive page.
        if (is_post_type_archive('winner')) {
            $query->set( 'orderby', array('date' => 'DESC') );
        }

        // Sort by title for video archive page.
        if (is_post_type_archive('video')) {
            $query->set( 'orderby', array('title' => 'ASC') );
        }
    }

    // Game list
    if(is_post_type_archive('game')){
        $meta_query = ( is_array( $query->get('meta_query') ) ) ? $query->get('meta_query') : [];
        
        $meta_query[] = array(
            'key'		=> 'game_type',
            'value'		=> 'op_game',
            'compare'	=> '=',
        );
        // update meta query
        $query->set('meta_query', $meta_query);
    }
}
add_action( 'pre_get_posts', 'bf_get_list_post' );

/**
 * Alter where clause to get list article by current post.
 * @return [type] [description]
 */
function bf_get_more_articles_by_postdate($sql_where, $args) {
    if (isset($args['post_date'])) {
        $sql_where .= " AND post_date <= '" . $args['post_date'] . "'";
    }
    if (isset($args['post_id'])) {
        $sql_where .= " AND ID <> " . $args['post_id'];
    }

    return $sql_where;
}
add_filter( 'getarchives_where', 'bf_get_more_articles_by_postdate', 10, 2);

/**
 * Add active class base on URI
 * @param  [type] $uri [description]
 * @return [type]      [description]
 */
function bf_add_active_class_menu($uri) {
    global $wp;
    $current_paths = explode('/', $wp->request);
    $target_paths = explode('/', $uri);

    $max = max(count($current_paths), count($target_paths));
    $is_active = true;
    for ($i = 0; $i < $max; $i++) {
        $value = empty($target_paths[$i]) ? false : $target_paths[$i];
        if (isset($current_paths[$i]) && !$value) {
            $is_active = false;
            break;
        }

        if (!isset($current_paths[$i])
            || ($current_paths[$i] !== $value && $value !== '%')) {
            $is_active = false;
            break;
        }
    }

    if ($is_active) {
        echo "active";
    }
    return "";
}

/**
 * Remove [...] in the_excerpt().
 *
 * @param  [type] $more [description]
 * @return [type]       [description]
 */
function bf_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'bf_excerpt_more');

/**
 * Adding Order fee.
 * @return [type] [description]
 */
function bf_add_order_fee() {
    global $woocommerce;

    if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
        return;
    }

    $fee = bf_get_field_acf_group('order_fee');
    $title = __("Order Fee", 'cart');

    $woocommerce->cart->add_fee( $title, $fee, TRUE, 'standard' );
}
add_action( 'woocommerce_cart_calculate_fees', 'bf_add_order_fee' );

/**
 * Add new fields into billing address.
 *
 * @param  [type] $fields [description]
 * @return [type]         [description]
 */
function bf_woocommerce_billing_fields($fields)
{
    // Prepend new element field into array.
    $tmp = $fields;
    $fields = []; 
    $fields['billing_gender']  = [
        'label' => __( 'Gender', 'myaccount' ),
        'type' => 'radio',
        'options' => ['male' => __('Male', 'myaccount'), 'female' => __('Female', 'myaccount')],
        'required' => true
    ];
    unset($tmp['billing_company']);
    $fields += $tmp;

    // Remove required email fields.
    $fields['billing_email']['required'] = false;
    return $fields;
}
add_filter('woocommerce_billing_fields', 'bf_woocommerce_billing_fields');

add_filter( 'body_class' , 'filter_body_class_user_logged_in');

function filter_body_class_user_logged_in($classes){
    if(is_user_logged_in()){
        $classes[] = 'user_logged_in';
    }else{
        $classes[] = 'user_non_logged_in';
    }
    // add class bf-default-layout, bf-game-layout
    $is_bf_game_layout = in_array('game-template-default',$classes);
    if($is_bf_game_layout){
        $classes[] = 'bf-game-layout';
    }else{
        $classes[] = 'bf-default-layout';
    }
    return $classes;    
}

add_action('wp_head', 'front_inline_js', 1);

function front_inline_js(){
    
    $messages = array(
        'first_name' => array('required' => __('*Enter your first name ', 'bf')),
        'last_name' => array('required' => __('*Enter your last name ', 'bf')),
        'user_dob' => array('required' => __('*Enter your date of birth', 'bf'), 'format' => __('*You must be 18 years of age or over to win our prize', 'bf')),
        'user_phone' => array('required' => __('*Enter your phone number', 'bf'), 'format' => __('*Phone number you&#8217;ve just provided is not valid. It should start with 0', 'bf')),
        'user_email' => array('required' => __('*Enter your email', 'bf'), 'format' => __('*Email address you&#8217;ve just provided is not valid value', 'bf')),
        'user_pwd' => array('required' => __('*Enter your password', 'bf'), 'format' => __('*Passwords must be at least 6 characters', 'bf')),
        'terms_condition' => array('required'=> __('*You must be accept this terms conditions', 'bf'))
    );
    $messages = wp_json_encode($messages);
    $aquisition_games = array();
    $first_agame = get_field('signup_flow_first_agame_link','option');
    $second_agame = get_field('signup_flow_second_agame_link','option');
    if(!empty($first_agame) && !empty($second_agame) ){
        $aquisition_games = array($first_agame, $second_agame);
    }
    if(empty($aquisition_games)){
        $aquisition_games = array(
            site_url('game-3'),
            site_url('game-atm'),
        );
    }
    
    
    $random_game = rand(0,1);
    $sign_up_flow = array(        
        'game' => '',
        'is_logged' => is_user_logged_in(),
        'random_game' => $aquisition_games[$random_game],
        'is_signup_page' => is_page_template( 'template-signup.php' ),        
    );    
    if(is_singular('game')){
        $sign_up_flow['game'] =  get_field('game', get_the_ID());                      
    }

    $sign_up_flow = wp_json_encode($sign_up_flow);

    echo "<script type='text/javascript'>\n";
    echo " var AJAX_URL = '" . get_bloginfo('url') . "/wp-admin/admin-ajax.php';\n";
    echo " var SITE_URL = '" . get_bloginfo('url') . "';\n";
    echo " var TEMPLATE_URL = '" . get_bloginfo('template_url') . "';\n";
    
    echo " var SIGN_UP_FLOW_PARAMS = $sign_up_flow;\n";    
    echo " var sign_up_messages = $messages;\n";
    echo "\n</script>";
}

/**
 * If more than one page exists, return TRUE.
 */
function show_posts_nav() {
    global $wp_query;
    return ($wp_query->max_num_pages > 1);
}

function bf_pager() {
    get_template_part('blocks/block-pager');
}

add_action( 'wp_ajax_my_cart_items_count', 'my_cart_items_count' );

function my_cart_items_count() {
    echo WC()->cart->get_cart_contents_count();
    die();	
}

include 'inc/menus.php';
include 'inc/acf-group-fields.php';

/* game type manage screen */

// ONLY GAME CUSTOM TYPE POSTS
add_filter('manage_game_posts_columns', 'bf_columns_head_only_games', 10);
add_action('manage_game_posts_custom_column', 'bf_columns_content_only_games', 10, 2);
 
// CREATE TWO FUNCTIONS TO HANDLE THE COLUMN
function bf_columns_head_only_games($defaults) {
    $defaults['game_type'] = 'Game Type';
    $defaults['game_name'] = 'Game Name';    
    return $defaults;
}
function bf_columns_content_only_games($column_name, $post_ID) {
    if ($column_name == 'game_name') {
        // show content of 'directors_name' column
        $field = get_field_object('game');        
        $game = get_field('game', $post_ID);
        if(isset($field['choices']) && !empty($game)){
            if(isset($field['choices'][$game])){
                echo $field['choices'][$game];
            }
        }
    }
    if ($column_name == 'game_type') {
        // show content of 'directors_name' column
        $field = get_field_object('game_type');     
        $game_type = get_field('game_type', $post_ID);
        if(isset($field['choices']) && !empty($game_type)){
            if(isset($field['choices'][$game_type])){
                echo $field['choices'][$game_type];
            }
        }
    }    
}

function bf_get_field($field_name, $post_id, $default_value = ''){
    $value = get_field($field_name, $post_id, $default_value);
    return !empty($value)? $value : $default_value;
}

function bf_get_field_options($field_name, $key, $post_id, $default_value = array()){
    $values = get_field($field_name, $post_id, $default_value);
    if(empty($values)) return $default_value;
    for ($i = 0; $i<= count($values) ; $i++){
        if(empty($values[$i][$key])){
            return $default_value;
        }
        else {
            $options = array();
            foreach($values as $value){
                array_push($options, $value[$key]);
            }
            return $options;
        }
    }
}

function bf_get_game1_options(){
    $game_assets_path = child_theme_assets('assets/images/games/game1', true);
    $options = array(
        'disclaimer' => bf_get_field('game1_disclaimer','option', '*Trò chơi này không tạo ra nghĩa vụ trả thưởng cho công ty. kh cần đọc kỹ thể lệ mặt trong phong bì và trên website.'),
        'title' => bf_get_field('game1_title','option', "$game_assets_path/title.png"),
        'game_explaination_top' => bf_get_field('game1_explaination_top','option', 'Rất đơn giản! Hãy tìm 3 mảnh ghép còn thiếu của chiếc Honda CRV bên dưới để có thể thắng ngay chiếc xe
        giá trị này*.'),
        'game_explaination_bottom' => bf_get_field('game1_explaination_bottom','option','Nhấn và di chuyển các mảnh ghép bạn chọn để hoàn thiện chiếc xe Honda CRV này.'),
        'first_puzzle_found' => bf_get_field('game1_first_puzzle_found','option', "$game_assets_path/first_puzzle_found.png"),
        'second_puzzle_found' => bf_get_field('game1_second_puzzle_found','option', "$game_assets_path/second_puzzle_found.png"),
        'congratulation_banner' => bf_get_field('game1_congratulation_banner','option', "$game_assets_path/congratulation_banner.jpg"),
        'congratulation_button' => bf_get_field('game1_congratulation_button','option', "$game_assets_path/congratulation_button.png"),
    );
    return $options;
}

function bf_get_game2_options(){
    $game_assets_path = child_theme_assets('assets/images/games/atm', true);

    $options = array(
        'title' => bf_get_field('game2_banner_title','option',"$game_assets_path/banner/game2_banner_title.png"),
        'subtitle' => bf_get_field('game2_banner_subtitle','option',"$game_assets_path/banner/game2_banner_subtitle.png"),
        'bottom' => bf_get_field('game2_banner_bottom','option',"$game_assets_path/banner/atm-banner-bottom.png"),
        'button' => bf_get_field('game2_banner_button','option',"$game_assets_path/banner/game2_banner_button.png"),
        'disclaimer' => bf_get_field('game2_disclaimer','option','*Trò chơi này không tạo ra nghĩa vụ trả thưởng cho công ty. kh cần đọc kỹ thể lệ mặt trong phong bì và trên website.'),
        'instruction_one' => bf_get_field('game2_instruction_one','option','Số tiền khủng này hiện đang nằm trong chiếc máy ATM này và có thể được trao cho Người sở hữu Mã số bí mật.*'),
        'instruction_two' => bf_get_field('game2_instruction_two','option','Bạn tìm thấy Mã số bí mật để có thể sở hữu số tiền 1.000.000.000 đồng? Cào ngay 3 lớp bảo vệ bên dưới để biết ngay.'),
        'congratulation_message' => bf_get_field('game2_congratulation_message','option','<strong>Xin chúc mừng</strong><br/>Bạn là Người sở hữu Mã số bí mật của <span class="bf-text-red">1.000.000.000</span> đồng trong chiếc mày ATM này*. Bạn có thể thắng số tiền này sớm thôi.'),
        'atm_signupbtn' => bf_get_field('game2_atm_signupbtn','option','Đăng ký ngay'),
    );
    return $options;
}
function bf_get_game3_options(){
    $game_questions_default = array(
        array(
            'g3_question' => 'Món ăn yêu thích nhất của mèo là gì?',
            'g3_answers' => array(
                array('g3_key' => 'A', 'g3_answer' => 'Cà rốt'),
                array('g3_key' => 'B', 'g3_answer' => 'Táo'),
                array('g3_key' => 'C', 'g3_answer' => 'Cá'),
                array('g3_key' => 'D', 'g3_answer' => 'Cơm')
            ),
            'g3_right_answer' => 'C'
        ),
        array(
            'g3_question' => 'Thủ đô của nước Pháp là?',
            'g3_answers' => array(
                array('g3_key' => 'A', 'g3_answer' => 'Băng Cốc'),
                array('g3_key' => 'B', 'g3_answer' => 'Cai-rô'),
                array('g3_key' => 'C', 'g3_answer' => 'Mát-xcơ-va'),
                array('g3_key' => 'D', 'g3_answer' => 'Pa-ri')
            ),
            'g3_right_answer' => 'D'
        ),
        array(
            'g3_question' => 'Vật chất cứng nhất trên Trái Đất là gì?',
            'g3_answers' => array(
                array('g3_key' => 'A', 'g3_answer' => 'Kim cương'),
                array('g3_key' => 'B', 'g3_answer' => 'Thủy tinh'),
                array('g3_key' => 'C', 'g3_answer' => 'Gỗ'),
                array('g3_key' => 'D', 'g3_answer' => 'Nước')
            ),
            'g3_right_answer' => 'A'
        )                
    );    
    $game_assets_path = child_theme_assets('assets/images/games/wheel', true);
    $wheel_segments = get_field('game3_wheel_segments','option');
    if(empty($wheel_segments)){
        $wheel_segments = [  
            array('g3_wheel_segment_value' => 0),
            array('g3_wheel_segment_value' => 150000000),
            array('g3_wheel_segment_value' => 1000000),
            array('g3_wheel_segment_value' => 200000),
            array('g3_wheel_segment_value' => 0),
            array('g3_wheel_segment_value' => 990000000),
            array('g3_wheel_segment_value' => 9000000),
            array('g3_wheel_segment_value' => 200000),
            array('g3_wheel_segment_value' => 500000000),
            array('g3_wheel_segment_value' => 500000),
        ];
    }

    $spins = get_field('game3_spins','option');
    if(empty($spins)){
        $spins = array(
            array(
                'game3_spin_title' => "Xin chúc mừng!<br/>Bạn quay được<br/>1.000.000 đồng!",
                'game3_spin_subtitle' => "Muốn tăng số tiền của bạn, trả lời câu tiếp theo ngay!",
                'game3_spin_button' => "Tiếp tục",
                'game3_spin_value' => 1000000,
                'game3_spin_status' => "Xin chúc mừng! Số tiền bạn có thể thắng là<br/>1.000.000 đồng*."
            ),
            array(
                'game3_spin_title' => "Xin chúc mừng!<br/>Bạn quay được<br/>9.000.000 đồng!",
                'game3_spin_subtitle' => "Muốn tăng số tiền của bạn, trả lời câu tiếp theo ngay!",
                'game3_spin_button' => "Tiếp tục",
                'game3_spin_value' => 9000000,
                'game3_spin_status' => "Xin chúc mừng! Số tiền bạn có thể thắng là<br/>10.000.000 đồng*."
            ),
            array(
                'game3_spin_title' => "Xin chúc mừng!<br/>Bạn quay được<br/>990.000.000 đồng!",
                'game3_spin_subtitle' => "",
                'game3_spin_button' => "Tiếp tục",
                'game3_spin_value' => 990000000,
                'game3_spin_status' => "Xin chúc mừng! Số tiền bạn có thể thắng là<br/>100.000.000 đồng*."
            )                                                                      
        );
    }
    
    $options = array(
        'banner_title' => bf_get_field('game3_banner_title','option', "$game_assets_path/banner/game3_banner_title.png"),
        'banner_subtitle' => bf_get_field('game3_banner_subtitle','option', "$game_assets_path/banner/game3_banner_subtitle.png"),
        'banner_button' => bf_get_field('game3_banner_button','option', "$game_assets_path/banner/game3_banner_button.png"),
        'disclaimer' => bf_get_field('game3_disclaimer','option', '*Trò chơi này không tạo ra nghĩa vụ trả thưởng cho công ty. kh cần đọc kỹ thể lệ mặt trong phong bì và trên website.'),
        'title' => bf_get_field('game3_title','option', "$game_assets_path/game/game3_game_title.png"),
        'subtitle' => bf_get_field('game3_subtitle','option', "$game_assets_path/game/game3_subtitle.png"),
        'wheel_image' => bf_get_field('game3_wheel_image','option', "$game_assets_path/game/game3_wheel_image.png"),
        'wheel_segments' => $wheel_segments,
        'explaination' => bf_get_field('game3_explaination','option', "Trả lời các câu hỏi của chúng tôi. Nếu bạn có được đáp án đúng, bạn sẽ được quay Vòng quay Kỳ diệu 1 lần để biết số tiền bạn có thể thắng. Bạn có tất cả 3 câu hỏi và tối đa 3 lần quay. Đừng để lỡ bất kỳ cơ hội nào để gia tăng số tiền bạn có thể thắng lên 1.000.000.000 Đồng*."),
        'status_bar' => bf_get_field('game3_status_bar','option', "Bắt đầu!"),
        'questions' => bf_get_field('game3_questions','option', $game_questions_default),
        'popup_correct' => bf_get_field('game3_popup_correct','option',  "$game_assets_path/game/game3_popup_correct.png"),
        'popup_wrong' => array(
            'title' => bf_get_field('game3_popup_wrong_title','option', "Câu trả lời của bạn không chính xác. Hãy chọn câu trả lời khác."),
            'button' => bf_get_field('game3_popup_wrong_button','option', "Trả lời lại >>"),
        ),
        'popup_win' => array(
            'title' => bf_get_field('game3_popup_win_title','option', "Xin chúc mừng! Bạn đã<br/>thắng trò chơi này. Tổng<br/>số tiền bạn có thể thắng là<br/>1.000.000.000 Đồng*."),
            'button' => bf_get_field('game3_popup_win_button','option', "Thông báo ngay"),
        ),
        'spins' => $spins
    );
    return $options;
}

function bf_get_game4_options(){
    $game_assets_path = child_theme_assets('assets/images/games/game4', true);
    $game_data_default = '[{"id":"29993aad0875c51e93c7d8a37d876ad0","word":"hoamai","chars":"[94,95,96,97,98,99]"},{"id":"814c73d2d61b9643a6ac06133b828473","word":"hoadao","chars":"[70,71,72,73,74,75]"},{"id":"f24ce1cc3a05167499873771d302a19c","word":"hoalan","chars":"[60,61,62,63,64,65]"},{"id":"9c76a2a071d076e837c9cb2a9d0ddda6","word":"HOAHONG","chars":"[30,31,32,33,34,35,36]"},{"id":"57858249016b2d19617b6c870700bd8f","word":"HOASU","chars":"[55,56,57,58,59]"}]';
    $gameData  = json_decode(get_option('game4_data'));
    $game_data_default = empty($gameData) ? $game_data_default : stripslashes( get_option('game4_data') );
    $options = array(
        'disclaimer' => bf_get_field('game4_disclaimer','option', '*Trò chơi này không tạo ra nghĩa vụ trả thưởng cho công ty. KH cần đọc kỹ thể lệ trong phong bì và trên website'),
        'title' => bf_get_field('game4_title','option', "$game_assets_path/title.png"),
        'description' => bf_get_field('game4_description','option', "$game_assets_path/description.png"),
        'first_rank' => bf_get_field('game4_first_name_found','option', "$game_assets_path/game4_first_name_found.png"),
        'second_rank' => bf_get_field('game4_second_name_found','option', "$game_assets_path/game4_second_name_found.png"),
        'third_rank' => bf_get_field('game4_third_name_found','option', "$game_assets_path/game4_third_name_found.png"),
        'final_rank' => bf_get_field('game4_fourth_name_found','option', "$game_assets_path/game4_fourth_name_found.png"),
        'congratulation_banner' => bf_get_field('game4_congratulation_banner','option', "$game_assets_path/congrat.png"),
        'congratulation_button' => bf_get_field('game4_congratulation_button','option', "$game_assets_path/game4_congratulation_button.png"),
        'game_data' =>  $game_data_default
    );
    return $options;
}

function bf_get_game5_options(){
    $game_assets_path = child_theme_assets('assets/images/games/game5', true);

    $status_bar_default = array(
        'Hãy bắt đầu. Chọn ngay đáp án đúng!',
        'Bạn còn 4 câu hỏi để tiến gần hơn đến chiến thắng!',
        'Bạn còn 3 câu hỏi để tiến gần hơn đến chiến thắng!',
        'Bạn còn 2 câu hỏi để tiến gần hơn đến chiến thắng!',
        'Bạn còn 1 câu hỏi để tiến gần hơn đến chiến thắng!',
    );
    $popup_messages_default = array(
        'Tuyệt! <br/> Bạn đã trả lời chính xác câu đầu tiên!',
        'Tốt! <br/> Câu trả lời chính xác! Chỉ còn 3 câu hỏi nữa!',
        'Rất tốt! <br/> Câu trả lời của bạn chính xác!',
        'Tuyệt vời! <br/> Câu trả lời chính xác! Chỉ còn 1 câu hỏi thôi!',
    );

    $options = array(
        'disclaimer' => bf_get_field('game5_disclaimer','option', '*Trò chơi này không tạo ra nghĩa vụ trả thưởng cho công ty. KH cần đọc kỹ thể lệ trong phong bì và trên website'),
        'title' => bf_get_field('game5_title','option', "$game_assets_path/game5_title.png"),
        'subtitle' => bf_get_field('game5_subtitle','option', 'Bạn có thể thắng được bao nhiêu tiền ngày hôm nay? Khám phá ngay!'),
        'explanation' => bf_get_field('game5_explanation','option','Trả lời 5 câu hỏi của chúng tôi để tìm ra bạn có thể thắng bao nhiêu tiền. Nếu bạn trả lời đúng cả 5 câu hỏi, bạn có thể THẮNG 02 XE MÁY VESPA PRIMAVERA THỜI THƯỢNG'),
        'prize' => bf_get_field('game5_prize_amount','option',"$game_assets_path/game5_prize_amount.png"),
        'status_bar' => bf_get_field_options('game5_status_bar','status_bar_value','option', $status_bar_default),
        'popup_message' => bf_get_field_options('game5_correct_answer_popup', 'correct_answer_value','option', $popup_messages_default),
        'congratulation_popup' => bf_get_field('game5_congratulation_popup','option', "$game_assets_path/game5_congratulation_popup.png"),
        'stamp' => bf_get_field('game5_stamp','option', "$game_assets_path/game5_stamp.png"),
        'congratulation_message' => bf_get_field('game5_congratulation_message','option',' Bạn đã trả lời đúng tất cả các câu. <br/> Bạn có thể thắng 02 chiếc xe Thời thượng Vespa Primavera 2017 trị giá 150.000.000 đồng.'),
        'congratulation_banner_button' => bf_get_field('game5_congratulation_banner_button','option',"$game_assets_path/game5_congratulation_banner_button.png"),
        'button_continue' => bf_get_field('game5_button_continue','option',"Tiếp tục"),
        'wrong_message' => bf_get_field('game5_wrong_popup_message','option','Câu trả lời của bạn chưa chính xác. <br/> Hãy thử lại'),
    );
    return $options;
}

add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
    global $woocommerce;

    if ( isset( $_GET['empty-cart'] ) ) {
        $woocommerce->cart->empty_cart();
        wp_redirect(home_url('/products/'));
        exit();
    }
}

add_action('init', 'bf_admin_style', 1);
function bf_admin_style(){
    global $path;
    if(is_admin()){
        $styles = array(
            'admin_dashboard'       => $path. '/admin-style.css',
        );
        $scripts = array(
            'admin_dashboard'       => $path. '/admin-script.js',
        );

        foreach( $styles as $k => $v )
        {
            wp_register_style( $k, $v, false);
        }
        foreach( $scripts as $k => $v )
        {
            wp_register_script( $k, $v, false);
        }        
    }
}

add_action('admin_footer', 'bf_admin_footer');

function bf_admin_footer(){
    wp_enqueue_style('admin_dashboard');
    wp_enqueue_script('admin_dashboard');
}

add_action('admin_head', 'admin_inline_js', 1);

function admin_inline_js(){
    
    echo "<script type='text/javascript'>\n";
    echo " var AJAX_URL = '" . get_bloginfo('url') . "/wp-admin/admin-ajax.php';\n";
    echo " var SITE_URL = '" . get_bloginfo('url') . "';\n";
    echo " var TEMPLATE_URL = '" . get_bloginfo('template_url') . "';\n";
    echo "\n</script>";
}

add_action('init','bf_cookie_init');

function bf_cookie_init() {   
  if(!isset($_COOKIE['bf_visited_cookie'])){
    $visited = 1;
    setcookie('bf_visited_cookie', $visited, time() + (10 * 365 * 24 * 60 * 60), "/");
  }
  if(!isset($_COOKIE['bf_prev_cookie'])){
    $bf_prev_cookie = 'not_game';
    setcookie('bf_prev_cookie', $bf_prev_cookie, time() + (10 * 365 * 24 * 60 * 60), "/");
  }  
}

function bf_gameflow_redirect(){
    if( is_user_logged_in() ){
        return site_url('products');
    }
    return site_url('sign-up');
}

function bf_get_archives_link($item){
    if ( $item->post_date != '0000-00-00 00:00:00' ) {
        $url = get_permalink( $item );
        if ( $item->post_title ) {
            $text = strip_tags( apply_filters( 'the_title', $item->post_title, $item->ID ) );
        } else {
            $text = $item->ID;
        }
        return get_archives_link( $url, $text);
    }
    return '';
}