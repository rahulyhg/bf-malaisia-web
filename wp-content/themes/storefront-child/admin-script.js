(function($) {
    var AdminBlueFox = AdminBlueFox || {};
    AdminBlueFox = {      
      bootstrap: function(){
        this.game3Settings();
      },
      game3Settings: function(){
        if($('#wheel_image_example .acf-input').length > 0){
            let wheel_image_example = '<img src="' + TEMPLATE_URL + '-child/assets/images/games/wheel/game/game3_wheel_image.png' + '" alt="example wheel image" />';
            $('#wheel_image_example .acf-input').append(wheel_image_example);
            $('#wheel_image_example .acf-input').append('<p><strong>The value of Prize will start from first segment at 12 o\'clock</strong></p>');
            $('#wheel_image_example .acf-input').append('<strong>Please keep the wheel rotation same as example design</strong>');
        }
      }
    };
    $(document).ready(()=>{
        AdminBlueFox.bootstrap();
    });    
})(jQuery);