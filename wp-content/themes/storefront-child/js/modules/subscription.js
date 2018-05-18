const $sub = $('.bf-subscription');
const $bfSlider = $('.bf-banner');

const $delay = 600;
const $animation_speed = 'slow';
const $animation_easing = 'linear';

const $popupSubscription = $('#popup-subscription');
class Subscription{
    constructor(){
        if($bfSlider.length > 0){
            this.init();            
        }
    }

    init(){
      let $subHeight = $sub.innerHeight()/2;
      let $headerHeight = $('header').innerHeight();
      let windowWidth = window.innerWidth;
      setTimeout(()=>{
          this.top = $bfSlider.offset().top;
          this.bottom = windowWidth > 1023  ? this.top + $bfSlider.innerHeight() - $subHeight - $headerHeight :  this.top + $bfSlider.innerHeight() - $subHeight - $headerHeight + 10;
          $sub.addClass('translate-sub');
          if (!$('#modal-login-form').hasClass('show')) {
             $sub.removeClass('hidden').animate({
               top: this.bottom
             }, $animation_speed, $animation_easing, function() {
               // Animation complete.
             });
          }else{
              $sub.animate({
                  top: this.bottom
              }, $animation_speed, $animation_easing, function() {
                  $sub.removeClass('hidden');
              });
          }
      },$delay);

      $sub.click(()=>{
          $popupSubscription.modal('show');
      });
    }
}

export default Subscription