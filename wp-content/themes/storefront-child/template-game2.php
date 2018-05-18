<?php
/**
 * The template for displaying the Game 2.
 *
 * Template name: Game 2 - ATM
 *
 * @package storefront-child
 */
get_template_part('parts/head');
$game2_options = bf_get_game2_options();

function generateRandomString($length = 10) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$arrChances = array(
  generateRandomString(6) ,
  generateRandomString(6),
  generateRandomString(6)
);
$win_index = rand(0,2);
$privatecode = $arrChances[$win_index];

?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/js/scratchie.js' ?>"></script>
<div class="bf-game-page-table"><div class="bf-game-page-cell">
    <div id="atm-banner-page">
    <div class="atm-banner">
        <img src="<?php child_theme_assets('assets/images/games/atm/banner/atm-banner-bg.png'); ?>" alt="" />
        <div class="atm-banner-content">
        <div class="atm-banner-title">
            <img src="<?php echo $game2_options['title'] ?>" alt="">
        </div>
        <div class="atm-banner-bottom">
            <img src="<?php echo $game2_options['bottom'] ?>" alt="">
            <div class="atm-banner-subtitle">
                <img src="<?php echo $game2_options['subtitle'] ?>" alt="">
            </div>
            <div class="atm-banner-button">
                <a href="javascript:void(0);" 
                class="start-game"><img src="<?php echo $game2_options['button'] ?>" alt=""></a>
            </div>        
        </div>      
        </div>
    </div>
    </div>

    <div id="atm-game-page" class="hidden">
        <div class="atm-game container">
            <div class="atm-game-title">
                <div class="atm-game-disclaimer">
                    <?php echo $game2_options['disclaimer'] ?>
                </div>
                <img src="<?php echo $game2_options['title'] ?>" alt="">
            </div>
            <div class="atm-game-row row clearfix">
                <div class="instruction-column col-md-6">
                    <div class="instruction-row instruction-row-arrow instruction-row-red">
                        <?php echo $game2_options['instruction_one']?>
                    </div>
                    <div class="instruction-row private-number instruction-row-arrow instruction-row-yellow">
                        <span id="privatecode"><?php echo $privatecode; ?></span>
                    </div>
                    <div class="instruction-row instruction-row-blue">
                        <?php echo $game2_options['instruction_two']?>
                    </div>                
                </div>
                <div class="atm-column col-md-6">
                    <div class="atm-image">
                        <img src="<?php child_theme_assets('assets/images/games/atm/game/atm-lock.png'); ?>" alt="" />
                        <div class="atm-image-open lock">
                            <img src="<?php child_theme_assets('assets/images/games/atm/game/atm-open.png'); ?>" alt="" />
                        </div>
                        <div class="atm-image-scratch-wrong hidden"><?php var_dump($game2_options['popupmessage']) ?></div>
                        <img class="atm-image-win hidden" src="<?php child_theme_assets('assets/images/games/atm/game/atm-win.png'); ?>" alt="" />
                        <img class="atm-image-money hidden" src="<?php child_theme_assets('assets/images/games/atm/game/atm-money.png'); ?>" alt="" />
                        <div class="game-play-number">
                            <span class="num">?</span>
                            <span class="num">?</span>
                            <span class="num">?</span>
                            <span class="num">?</span>
                            <span class="num">?</span>
                            <span class="num">?</span>
                        </div>    
                    </div>
                    <div class="atm-image-scratch">
                    <?php for($i=0;$i<count($arrChances);$i++):?>
                        <div class="scratch-col col-md-4">                
                            <div class="scratch-box">
                                <div class="scratch-box-title">
                                    <?php echo __('Chance ','bf').($i+1); ?>
                                </div>
                                <div class="scratch-box-content">
                                    <div data-number="<?php echo $arrChances[$i]; ?>"
                                    class="scratch-box-image enabled" data-scratchie="<?php echo get_stylesheet_directory_uri() . '/assets/images/games/atm/game/scratch.png' ?>">
                                        <div class="scratch-box-number"><?php echo $arrChances[$i]; ?></div>                            
                                    </div>
                                    <?php if($privatecode == $arrChances[$i]) : ?>
                                        <div class="scratch-box-valid hidden">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/games/atm/game/valid-icon.png' ?>" alt="valid" />
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endfor;?>                    
                    </div>
                </div>
            </div>
            <div class="atm-game-row atm-image-scratch-others row clearfix">
                <?php for($i=0;$i<count($arrChances);$i++):?>
                <div class="scratch-col col-md-4">                
                    <div class="scratch-box">
                        <div class="scratch-box-title">
                            <?php echo __('Chance ','bf').($i+1); ?>
                        </div>
                        <div class="scratch-box-content">
                            <div data-number="<?php echo $arrChances[$i]; ?>"
                            class="scratch-box-image enabled" data-scratchie="<?php echo get_stylesheet_directory_uri() . '/assets/images/games/atm/game/scratch.png' ?>">
                                <div class="scratch-box-number"><?php echo $arrChances[$i]; ?></div>                            
                            </div>
                            <?php if($privatecode == $arrChances[$i]) : ?>
                                <div class="scratch-box-valid hidden">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/games/atm/game/valid-icon.png' ?>" alt="valid" />
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endfor;?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="atm-game-popup" tabindex="-99" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text text-center">
                        <?php echo $game2_options['congratulation_message']?>
                    </div>                
                    <a class="atm-game-signupbtn game-signup-action" href="<?php echo site_url('sign-up') ?>"><?php echo $game2_options['atm_signupbtn'];?></a>
                </div>
            </div>
        </div>
    </div>
</div></div>
<div class="rotate-game">
    <p>Xoay thiết bị để tiếp tục chơi</p>
</div>

<script type="text/javascript">


(function($) {

    var ATMGame = ATMGame || {};
    ATMGame = {
        privateCode: null,
        scratchie: null,
        chances: 3,
        STATUS_START: 1,
        STATUS_FALSE: 2,
        STATUS_TRUE: 3,
        updateATMNumber(num_str, status){
            let nums_html = '';
            for(let i = 0; i< num_str.length; i++){
                nums_html += '<span class="num">' + num_str.substring(i,i+1) + '</span>';
            }
            $('.game-play-number').html(nums_html);
            if(status == this.STATUS_START){
                // start game
                this.chances = 3;
                $('.game-play-number').addClass('red-color');
            }else if(status == this.STATUS_FALSE){
                $('.game-play-number').removeClass('red-color');
                this.chances -= 1;
                this.chances = Math.max(0, this.chances);
                if(this.chances != 0){
                    // end game
                    if(this.chances > 1){
                      $('.atm-image-scratch-wrong').html('<?php echo __('Try again!<br />You have 2 more <br />chances.','bf');?>');
                    }else{
                      $('.atm-image-scratch-wrong').html('<?php echo __('Try again!<br />You have 1 more <br />chance.','bf');?>');
                    }    
                    $('.atm-image-scratch-wrong').fadeIn('fast', function(){
                    });
                }
                // show errors
            }else if(status == this.STATUS_TRUE){
                $('.game-play-number').addClass('red-color');
                this.chances = 0; // end game
                // REMOVE WROING SCRATCH IMAGE
                $('.atm-image-scratch-wrong').remove();
                // SHOW PRIVATE CODE
                $('#privatecode').removeClass('hidden-code');
                // show valid icon and effects
                $('.scratch-box-valid').fadeIn('fast',function(){
                    // show valid icon bigger
                    $('.atm-image-win').fadeIn('normal',function(){
                        $('.atm-image-win').animate
                        ({
                            // "margin": "-350px 0 0 19px",
                            top:'-210px',
                            left:'-210px',
                            width: "190%",
                            height: "auto",
                            opacity: 0.5,
                            }, 1200,'', function() {
                                $('.atm-image-win').remove();
                                // UNLOCK ATM
                                $('.atm-image-open').removeClass('lock');
                                // FLY MONEY
                                $('.atm-image-money').fadeIn('fast').animate({
                                    left:'-50px',
                                    width: '500px',
                                    height: 'auto',
                                }, 1200, '',function(){
                                    // show popup register
                                    ATMGame.showPopup();
                                });
                        });
                    });
                    // END GAME
                    ATMGame.endGame();
                });
            }            
        },
        bootstrap: function(code){
            this.privateCode = code;
            $('.start-game').click(function(e){
                e.preventDefault();
                // hide banner
                $('#atm-banner-page').fadeOut('normal',function(){
                    $('#atm-game-page').fadeIn('normal');
                    ATMGame.startGame();
                });
            });                        
        },
        startGame: function(){
            this.initScratch();
            $('.scratch-box-image[data-number="' + this.privateCode + '"]').addClass('privatecode');
            $('#privatecode').html(this.privateCode);
            ATMGame.updateATMNumber('??????', this.STATUS_START);
        },
        endGame: function(){            
            var elements = document.querySelectorAll('[data-scratchie]');            
            for (var i = 0, l = elements.length; i < l; i++) {
                elements[i].scratchie.enabled = false;
            }            
        },
        showPopup: function(){
            let $popupRegister = $('#atm-game-popup');                    
            $popupRegister
            .modal({
                backdrop: 'static',
                keyboard: false  // to prevent closing with Esc button (if you want this too)
            })
            .modal('show');
        },
        initScratch: function(){
            this.scratchie = new Scratchie('[data-scratchie]', {
                brush: '<?php echo get_stylesheet_directory_uri() . '/assets/images/games/brush.png' ?>',
                onRenderEnd: function() {
                    // Show the form when Image is loaded.
                    // this.element.querySelectorAll('.scratchie__secret')[0].style.visibility = 'visible';
                },
                onScratchMove: function(filledInPixels) {                    
                    if(filledInPixels > 50){                
                        // this.element.querySelectorAll('.scratchie__secret')[0].removeChild(this.canvas);
                        
                        if($(this.element).hasClass('enabled')){
                            $(this.element).removeClass('enabled');
                            let scratch_number = $(this.element).attr('data-number').trim();
                            // // update game play number                            
                            if(scratch_number.localeCompare(ATMGame.privateCode) == 0){
                                ATMGame.updateATMNumber(scratch_number, ATMGame.STATUS_TRUE);
                            }else{
                                ATMGame.updateATMNumber(scratch_number, ATMGame.STATUS_FALSE);
                            }
                            // $('.atm-game .instruction-row.private-number').html(filledInPixels + '%');
                        }
                    }            
                }
            });
        }
    };
    $(document).ready(()=>{
        ATMGame.bootstrap('<?php echo $privatecode; ?>');
    });       
})(jQuery);
</script>
<?php get_template_part('parts/foot'); ?>