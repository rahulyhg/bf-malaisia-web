<?php
$body_classes = get_body_class();
$is_winner_page = in_array('page-template-template-winners-php',$body_classes);
$is_ourbrand_page = in_array('page-template-template-our-brand',$body_classes);
$is_home_page = in_array('home',$body_classes);
$is_winner_archive_page = in_array ('post-type-archive-winner', $body_classes);
global $bf_upload_url;
wp_footer();
if (!is_user_logged_in()) {
    get_template_part('popups/login');
} else {
    get_template_part('popups/product');
    get_template_part('popups/addtocart-onpage');
    get_template_part('popups/cancel-order');
    get_template_part('popups/addtocart-onpopup');

    //get_template_part('popups/money-back-guarantee');
	//get_template_part('popups/customer-review');
    
    get_template_part('popups/money-back-guarantee');
    get_template_part('popups/customer-review');
    
    
}
get_template_part('popups/game');
?>
<div class="modal fade modal-successful" id="popupGeneral" tabindex="-99" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo __('Warning', 'bf'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close-popup" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
    <?php
    $src_p4 = $bf_upload_url . '/assets/images/common/p4.png';
    $src_p3 = $bf_upload_url . '/assets/images/common/p3.png';
    $src_p2 = $bf_upload_url . '/assets/images/common/p2.png';
    $src_p1 = $bf_upload_url . '/assets/images/common/p1.png';
    $p4 = getimagesize($src_p4);
    $p3 = getimagesize($src_p3);
    $p2 = getimagesize($src_p2);
    $p1 = getimagesize($src_p1);
    ?>
    <div id="p1" class="p-animate">
        <img class="img-fluid" src="<?php echo $src_p4; ?>" alt="" data-width="<?php echo $p4[0] ?>"
             data-height="<?php echo $p4[1] ?>">
    </div>
    <div id="p2" class="p-animate">
        <img class="img-fluid" src="<?php echo $src_p3; ?>" alt="" data-width="<?php echo $p3[0] ?>"
             data-height="<?php echo $p3[1] ?>">
    </div>
    <div id="p3" class="p-animate">
        <img class="img-fluid" src="<?php echo $src_p2; ?>" alt="" data-width="<?php echo $p2[0] ?>"
             data-height="<?php echo $p2[1] ?>">
    </div>
    <div id="p4" class="p-animate">
        <img class="img-fluid" src="<?php echo $src_p1; ?>" alt="" data-width="<?php echo $p1[0] ?>"
             data-height="<?php echo $p1[1] ?>">
    </div>
</div>

<div class="modal fade" id="popupForgot" tabindex="-99" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo __('Warning', 'bf'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close-popup" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popupWinner" tabindex="-99" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content max-height-image">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="close-popup" aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row bf-row">
                    <?php if($is_ourbrand_page): ?>
                    <div class="col-md-6 bf-item">
                        <div class="winner-img"></div>
                        <div class="detail-add">
                            <div class="name-popup color-ourbrand"></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($is_winner_page || $is_home_page || $is_winner_archive_page): ?>
                        <div class="col-md-6 bf-item">
                            <div class="winner-img"></div>
                            <div class="detail-add">
                                <div class="name-popup color-home"></div>
                                <div class="summary-popup"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if(!$is_winner_page && !$is_ourbrand_page && !$is_home_page && !$is_winner_archive_page): ?>
                    <div class="col-md-6 bf-item winner-img">

                    </div>
                    <?php endif; ?>
                    <div class="col-md-6 bf-item winner-description">
                        <div class="text-scroll">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="popupSuccess" tabindex="-99" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var SignUpFlow = SignUpFlow || {};
    SignUpFlow = {
        game: "",
        is_second_visited: false,
        is_logged: false,
        random_game: "",
        is_signup_page: false,
        is_gamepage_previous : false,
        bootstrap: function(params){
            this.game = params.game;                        
            this.is_logged = params.is_logged;
            this.random_game = params.random_game;
            this.is_signup_page = params.is_signup_page; 
            this.is_second_visited = this.checkIsSecondVisisted();
            this.is_gamepage_previous = this.checkIsGamePagePrevious();            
            this.handleFlow();
        },
        checkIsGamePagePrevious: function(){
            let bf_previous_page = this.loadCookie('bf_prev_cookie', 'not_game');
            if(bf_previous_page == 'not_game'){
                return false;
            }
            return true;
        },
        checkIsSecondVisisted: function(){
            let bf_visited_cookie = parseInt(this.loadCookie('bf_visited_cookie', 0));                        
            if(bf_visited_cookie >= 2){
                return true;
            }
            //else increase to 2
            Cookies.set('bf_visited_cookie', bf_visited_cookie + 1, { expires: 10 * 365 * 24, path: '/' });
            return false;
        },
        loadCookie: function(name, default_value){
            var cookie_value = Cookies.get(name);
            
            if(typeof cookie_value == "undefined"){
                return default_value;
            }            
            return cookie_value;
        },
        handleFlow: function(){
            console.log(this);                        
            this.allFlows();
            this.updatePreviousPage();
        },
        updatePreviousPage: function(){
            let bf_prev_cookie = 'not_game';
            if(this.game != ''){
                bf_prev_cookie = this.game;
            }
            if(!this.is_signup_page){
                Cookies.set('bf_prev_cookie', bf_prev_cookie, { expires: 10 * 365 * 24, path: '/' });
            }
        },
        allFlows: function(){
            if(!this.is_logged){       
                if( this.game == 'game2' 
                    || this.game == 'game3'
                    || (this.is_signup_page && this.is_gamepage_previous)
                    || this.is_second_visited
                ){
                    // do not redirect in this case                
                    if(this.is_signup_page && !this.is_gamepage_previous && jQuery('#registerform').length > 0){
                        jQuery('#registerform').attr('data-redirect', jQuery('#registerform').attr('data-redirect-game'));
                    }
                }else{
                    // redirect to random aquisition game
                    this.redirect(this.random_game);
                }
            }                    
        },
        redirect: function(url){
            window.location = url;
        }
    }
    SignUpFlow.bootstrap(SIGN_UP_FLOW_PARAMS);
</script>
</body>
</html>