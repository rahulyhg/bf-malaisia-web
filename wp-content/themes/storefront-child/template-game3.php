<?php
/**
 * The template for displaying the Game 2.
 *
 * Template name: Game 3 - Wheel of fortune
 *
 * @package storefront-child
 */
get_template_part('parts/head');
function find_spin_prize($segments, $spin){  
  for($i = 0; $i < count($segments); $i++ ){  
    if($spin['game3_spin_value'] == $segments[$i]['g3_wheel_segment_value']){
      return ($i + 1);
    }
  }
  return -1;
}
// load game options
$game3_options = bf_get_game3_options();

$spins = $game3_options['spins'];
$wheel_segments = $game3_options['wheel_segments'];

$spin_prizes = array();
foreach($spins as $spin){
  $spin_prize = find_spin_prize($wheel_segments, $spin);
  array_push($spin_prizes,$spin_prize);
}
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/js/winwheel.min.js' ?>"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() . '/js/tweenMax.min.js'; ?>"></script>
<div class="bf-game-page-table"><div class="bf-game-page-cell">
  <div id="wheel-banner-page">
    <div class="wheel-banner">
      <img src="<?php child_theme_assets('assets/images/games/wheel/banner/banner-bg.jpg'); ?>" alt="" />
      <div class="wheel-banner-content">
        <div class="wheel-banner-title">
          <img src="<?php echo $game3_options['banner_title']; ?>" alt="" />
        </div>
        <div class="wheel-banner-subtitle">
          <img src="<?php echo $game3_options['banner_subtitle']; ?>" alt="" />
        </div>
        <div class="wheel-banner-button">
          <a href="javascript:void(0);" 
          class="wheel-banner-start-game"><img src="<?php echo $game3_options['banner_button']; ?>" alt="" /></a>
        </div>
      </div>
    </div>
  </div>
  <div id="wheel-game-page" class="hidden">
    <div class="game-wrapper">
      <div class="game-title">
        <img src="<?php echo $game3_options['title']; ?>" alt="" />
      </div>
      <div class="game-subtitle">
        <img src="<?php echo $game3_options['subtitle']; ?>" alt="" />
      </div>
      <div class="game-content clearfix">
          <div class="game-question">
            <div class="game-explaination">
              <?php echo $game3_options['explaination']; ?>            
            </div>
            <div class="question-panel visibility-hidden">
              <div class="question-panel-header">
                <span class="q-number">Q1</span>
                <span class="q-content">Câu hỏi?</span>
              </div>
              <div class="question-panel-content">
                <div class="answer-list">
                  <a class="answer enabled" data-key="A" href="javascript:void(0);"><span>A. dap an a</span></a>
                  <a class="answer enabled" data-key="B" href="javascript:void(0);"><span>B. dap an b</span></a>
                  <a class="answer enabled" data-key="C" href="javascript:void(0);"><span>C. dap an c</span></a>
                  <a class="answer enabled" data-key="D" href="javascript:void(0);"><span>D. dap an d</span></a>
                </div>
              </div>
            </div>
          </div>
          <div class="game-wheel">
            <div class="game-wheel-bg">
              <a href="javascript:void(0);" class="spin-trigger"></a>
              <canvas id="wheel-canvas" width="454" height="454">
                  Canvas not supported, use another browser.
              </canvas>            
              <img class="game-wheel-pointer" src="<?php child_theme_assets('assets/images/games/wheel/game/game-wheel-pointer.png'); ?>" alt=""/>
            </div>
          </div>
      </div>
      <div class="game-bottom">
        <div class="game-bottom-bg">
          <div class="status-bar-wrap">
            <div class="status-bar"><?php echo $game3_options['status_bar']; ?></div>
          </div>
        </div>
        <div class="disclaimer">
          <?php echo $game3_options['disclaimer']; ?>
        </div>
      </div>
    </div>
  </div>
</div></div>
<div class="modal bd-example-modal-lg wheel-game-popup fade" id="wheel-game-popup-correct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">        
        <div class="modal-body">
          <a href="javascript:void(0);" data-dismiss="modal">
            <img src="<?php echo $game3_options['popup_correct']; ?>" alt=""/>
          </a>
        </div>
    </div>
    </div>
</div>

<div class="modal bd-example-modal-lg wheel-game-popup fade" id="wheel-game-popup-wrong" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">        
        <div class="modal-body">
          <a class="wrong-btn" href="javascript:void(0);" data-dismiss="modal">
            <?php echo $game3_options['popup_wrong']['title']; ?>
            <br/>
            <span class="continue-text"><?php echo $game3_options['popup_wrong']['button']; ?></span>
          </a>     
        </div>
    </div>
    </div>
</div>

<div class="modal bd-example-modal-lg wheel-game-popup fade" id="wheel-game-popup-congrate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">        
        <div class="modal-body">
          <div class="win-congrat-title">
            Xin chúc mừng!<br/>
            Bạn quay được<br/>
            <span class="win-congrat-money">1.000.000 đồng</span>
          </div>
          <div class="win-congrat-subtitle">
            Muốn tăng số tiền của bạn, trả lời câu tiếp theo ngay!
          </div>
          <a class="cta-button" href="javascript:void(0);" data-dismiss="modal">
            Tiếp theo
          </a>
        </div>
    </div>
    </div>
</div>

<div class="modal bd-example-modal-lg wheel-game-popup fade" id="wheel-game-popup-win" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">  
        <div class="modal-body">
            <div class="message">
              <img class="win-congrat-image" src="<?php child_theme_assets('assets/images/games/wheel/game/win-congrat.png') ?>" alt="" />
              <div class="message-inner">
                <?php echo $game3_options['popup_win']['title']; ?>
                <div class="cta">
                  <a class="cta-button" href="<?php echo bf_gameflow_redirect(); ?>"><?php echo $game3_options['popup_win']['button']; ?></a>
                </div>                
              </div>
            </div>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">

(function($) {

    var WheelGame = WheelGame || {};
    WheelGame = {
      theWheel: null,
      segments: [],
      questions: [],
      spinPrizes: [],
      current_q: -1,
      stopSegment: -1,
      popupDelay: 500,
      popupSpins: [],
      statusBar: [],
      totalMoney: 0,
      enableClick: true,
      smoothScrollToElement: function(selector, pos_buffer) {
        let $el = $(selector);
        let scroll = $el.offset().top + pos_buffer;
        if ($el.length > 0) {
            $('html, body').stop()
            .animate({scrollTop: scroll}, 500, function () {
                //$(this).find($el).focus();
            });
        }
      },
      bootstrap: function(segments, questions, spin_prizes, popup_spins){        
        $('.wheel-banner-start-game').click(function(){
          $('#wheel-banner-page').remove();
          $('#wheel-game-page').removeClass('hidden');          
          WheelGame.startGame(segments, questions, spin_prizes, popup_spins);
        });
      },
      startGame: function(segments, questions, spin_prizes, popup_spins){
        this.popupSpins = popup_spins;
        this.spinPrizes = spin_prizes;    
        this.initWheel(segments);
        this.initQuestions(questions);
      },
      initQuestions: function(questions){
        this.questions = questions;
        this.current_q = 0;
        this.nextQuestion(this.current_q);
        this.handleEvents();
      },
      handleEvents: function(){
        let self = this;
        $('.question-panel .answer').click(function(){
          if($(this).hasClass('enabled') && WheelGame.enableClick){
            if(self.current_q > -1 && self.questions.length > 0 && self.current_q < self.questions.length){
              WheelGame.enableClick = false;
              let answer_result = WheelGame.checkAnswer($(this).attr('data-key'));
              $(this).removeClass('enabled');
              if(answer_result){
                // stop question game
                $('.question-panel .answer').removeClass('enabled');
                // add right class
                $(this).addClass('right');
                // enable spin
                WheelGame.showCorrectPopup(function(){           
                  WheelGame.enableSpinWheel();
                });
              }else{              
                // add wrong class  
                $(this).addClass('wrong');
                WheelGame.showWrongPopup();
              }
            }
          }  
        });
        
        $('#wheel-game-popup-congrate').on('hidden.bs.modal', function (e) {
          // reset wheel
          WheelGame.resetWheel();
          // next question
          WheelGame.current_q += 1;
          if(WheelGame.current_q < WheelGame.questions.length){
            WheelGame.nextQuestion(WheelGame.current_q);
            // allow wheel spin
            if( $('.game-wheel').css('float') == 'left' ){
              console.log('float');
            }else{
              console.log('scroll to questions');
              WheelGame.smoothScrollToElement('.question-panel', -30 );            
            }                     
          }else{
            WheelGame.showWinPopup(0);
          }          
        });
        
        $('#wheel-game-popup-congrate').on('shown.bs.modal', function (e) {
          if(WheelGame.current_q == WheelGame.questions.length - 1){ // final wheel congrate            
            WheelGame.showWinPopup(5000);
          }                             
        });  

        $('#wheel-game-popup-wrong').on('shown.bs.modal', function (e) {
          WheelGame.enableClick = true;
        });

        $('#wheel-game-popup-correct').on('shown.bs.modal', function (e) {
          WheelGame.enableClick = true;
        });

        $('#wheel-game-popup-correct').on('show.bs.modal', function (e) {
          // allow wheel spin
          if( $('.game-wheel').css('float') == 'left' ){
            console.log('float');
          }else{
            console.log('scroll to wheel');
            WheelGame.smoothScrollToElement('#wheel-canvas', 0 );            
          }
        });        

      },
      numberFormat(n){
        return String(n).replace(/(.)(?=(\d{3})+$)/g,'$1,');
      },
      enableSpinWheel: function(){
        $('.spin-trigger').addClass('enabled');
      },
      showWrongPopup: function(){
        setTimeout(function(){
          $('#wheel-game-popup-wrong').modal('show');
        }, WheelGame.popupDelay);
        
      },
      showCorrectPopup: function(callback){
        setTimeout(function(){
          $('#wheel-game-popup-correct').modal('show')
          .on('hidden.bs.modal', function (e) {            
            callback();
          });
        }, WheelGame.popupDelay);
      },
      setCurrentPopupCongrate: function(){
        // $('#wheel-game-popup-congrate .win-congrat-money').html(
        //   this.numberFormat(this.totalMoney)
        // );
        let currentSpinPopup = this.popupSpins[WheelGame.current_q];        
        $('#wheel-game-popup-congrate .win-congrat-title').html(
          currentSpinPopup.game3_spin_title
        );
        $('#wheel-game-popup-congrate .win-congrat-subtitle').html(
          currentSpinPopup.game3_spin_subtitle
        );
        $('#wheel-game-popup-congrate .cta-button').html(
          currentSpinPopup.game3_spin_button
        );
        if(currentSpinPopup.game3_spin_status != ''){
          setTimeout(function(){          
            $('.status-bar').html(currentSpinPopup.game3_spin_status);
          }, WheelGame.popupDelay + 500);
        }
      },
      showWinCongrat: function(value){
        this.totalMoney = value;     
        this.setCurrentPopupCongrate();
        setTimeout(function(){          
          $('#wheel-game-popup-congrate').modal('show');
        }, WheelGame.popupDelay);
      },
      showWinPopup: function(popupDelay){        
        setTimeout(function(){
          $('#wheel-game-popup-win').modal('show');
        }, popupDelay);        
      },
      nextQuestion: function(q_index){
        if(q_index < this.questions.length){
          this.stopSegment = this.spinPrizes[q_index];        
          let q = this.questions[q_index];                 
          this.prepareQuestion(q_index, q);   
        }
      },
      checkAnswer: function(key){
        if(this.current_q > -1 ){
          let q = this.questions[this.current_q];
          if(q.g3_right_answer == key){
            return true;
          }
        }
        return false;
      },
      prepareQuestion: function(number, q){
        number = parseInt(number) + 1;
        $('.question-panel .q-number').html('Q' + number);
        $('.question-panel .q-content').html(q.g3_question);        
        $('.question-panel .answer')
          .removeClass('wrong')
          .removeClass('right');
          $('.question-panel .answer').addClass('enabled');
        let char_arrays = ['A','B','C','D'];
        for(var i = 0; i < q.g3_answers.length; i++){
          let a = q.g3_answers[i];
          $('.question-panel .answer[data-key="' + char_arrays[i] + '"] span').html(char_arrays[i] + '. ' + a.g3_answer);          
        }
        $('.question-panel').removeClass('visibility-hidden');
      },
      initWheel: function(segments){
        this.segments = segments;
        this.theWheel = new Winwheel({
          'canvasId'          : 'wheel-canvas',
          'numSegments'       : 54,         // Specify number of segments.
          'outerRadius'       : (454/2),       // Set outer radius so wheel fits inside the background.
          'drawMode'          : 'image',   // drawMode must be set to image.
          'drawText'          : false,      // Need to set this true if want code-drawn text on image wheels.                
          'innerRadius'     : 50,         // Make wheel hollow so segments don't go all way to center.
          'textFontSize'    : 24,         // Set default font size for the segments.
          'textOrientation' : 'vertical', // Make text vertial so goes down from the outside of wheel.
          'textAlignment'   : 'outer',    // Align text to outside of wheel.
          'numSegments'     : 10,         // Specify number of segments.
          'textStrokeStyle' : 0,
          'pointerAngle'    : 180,
          'rotationAngle'   : -18,
          'pointerGuide'    : {
            'display'     : true
          },
          'segments'     :  segments,
          'animation' : {
              'type'     : 'spinToStop',
              'duration' : 9,     // Duration in seconds.
              'spins'    : 3,     // Default number of complete spins.
              'callbackFinished' : WheelGame.callbackFinished
          }
        });        
        var loadedImg = new Image();
        loadedImg.onload = function()
        {
          WheelGame.theWheel.wheelImage = loadedImg;    // Make wheelImage equal the loaded image object.
          WheelGame.theWheel.draw();               // Also call draw function to render the wheel.
        }        
        loadedImg.src = "<?php echo $game3_options['wheel_image']; ?>";       
        this.spinTrigger(this.theWheel);
      },
      spinTrigger: function(theWheel){
        $('.spin-trigger').click(function(){
          if ($(this).hasClass('enabled')) {
            $(this).removeClass('enabled');
            // wheel speed.
            theWheel.animation.spins = 10;//WheelGame.getRandomInt(5, 10);            
            // Get random angle inside specified segment of the wheel.
            var stopAt = theWheel.getRandomForSegment(WheelGame.getStopSegment());
            // Important thing is to set the stopAngle of the animation before stating the spin.
            theWheel.animation.stopAngle = stopAt;
            // Start the spin animation here.
            theWheel.startAnimation();
          }
        });
      },
      getStopSegment: function(){
        return this.stopSegment;
      },
      getRandomInt: function(min,max){
        return Math.floor(Math.random() * (max - min + 1)) + min;
      },
      resetWheel: function(){
        this.theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
        this.theWheel.rotationAngle = -18;     // Re-set the wheel angle to 0 degrees.
        this.theWheel.draw();                // Call draw to render changes to the wheel.
        $('.spin-trigger').removeClass('disabled'); // Reset to false to power buttons and spin can be clicked again.
      },
      callbackFinished: function(indicatedSegment){        
        WheelGame.showWinCongrat(indicatedSegment.value);        
      },
    };
    $(document).ready(()=>{
        WheelGame.bootstrap(<?php echo wp_json_encode($wheel_segments); ?>, 
        <?php echo wp_json_encode($game3_options['questions']); ?>, 
        <?php echo wp_json_encode($spin_prizes); ?>,
        <?php echo wp_json_encode($game3_options['spins']); ?>        
        );
    });       
})(jQuery);
</script>

<div class="game-rotate">
  <div class="game-rotate-inner">
    <div class="game-rotate-content">
      <p>Xoay thiết bị để tiếp tục chơi</p>
    </div>
  </div>
</div>

<?php get_template_part('parts/foot'); ?>
