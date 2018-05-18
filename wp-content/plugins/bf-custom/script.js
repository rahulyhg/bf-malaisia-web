(function($) {
    $.fn.showPopup = function(title, data){
        var $popup = $('#popupGeneral');
        $popup.on('hide.bs.modal',  () => {
            $('body').removeClass('popup-success');
        });

        $popup.on('show.bs.modal', () => {
            $('body').addClass('popup-success');
        });

        $popup.find('.modal-title').html(title);
        $popup.find('.modal-body').html(data);
        $popup.modal('show');
    };



    $.fn.showPopupForget = function(title, data){
        var $popup = $('#popupForgot');
        $popup.find('.modal-title').html(title);
        $popup.find('.modal-body').html(data);
        $popup.modal('show');
    };

    $.fn.ajaxPost = function(params, callback, e_callback){
        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: woocommerce_params.ajax_url,
          data: params,
          success: function(response) {
            if(response.success){//
              $.fn.showPopup(response.data.title,response.data.content);
              // show errors
              if (typeof callback === "function") {
                callback();
              }else{
                if(response.data.action == 'reload'){                  
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                }
              }
            }else{//Error
                $.fn.showError(response.data);
                if(typeof e_callback === "function"){
                  e_callback();
                }
              }
            },
            error: function(xhr, ajaxOptions, thrownError) {
              console.log(thrownError);
            }
        }).done(function() {
          
        });
    }
    $.fn.showError = function(errors){
      var html = '<ul class="list-errors">';
      $.each(errors, function( index, value ) {
        html = html + '<li>' + value.message + '</li>';
      });
      html = html + '</ul>';
      $('.bf-errors').html(html).fadeIn('fast','swing',function(){
        
      });
    };
    $.fn.loading = function(hide){
      if(hide == true){
          $('.ajax-progress-throbber').fadeOut("slow",function(){ $(this).remove(); });
        }else{
          $('body.page').append('<div class="ajax-progress ajax-progress-throbber"><div class="throbber">&nbsp;</div></div>');
        }
    };
    $(document).bind("ajaxSend", function(e, xhr, opt){
        if(typeof  opt.data != 'undefined' && opt.data.indexOf('action=bf_') > -1){
          $.fn.loading();
        } 
    }).bind("ajaxComplete", function(){
        $.fn.loading(true);
    });
	$(document).ready(function() {
	  $(".modal").on("show.bs.modal", function() {
	      var curModal;
	      curModal = this;
	      $(".modal").each(function() {
	        if (this !== curModal) {
	          $(this).modal("hide");
	        }
	      });
	    });
	  if(location.hash == '#login'){
	    $('#modal-login-form').modal('show');
	    location.hash = '';
	  }
	  $('.bf-forgetpass').click(function(){
	    $.fn.showPopupForget('',$(this).data('info'));
        return false;
      });
	  $( "#frm-subscription" ).submit(function( event ) {
        event.preventDefault();
        $.fn.ajaxPost('action=bf_ajax_newsletter&' + $(this).serialize(), false, false);
      });
	  $( "#loginform" ).submit(function( event ) {
        event.preventDefault();
        $.fn.ajaxPost('action=bf_login&' + $(this).serialize(), false, false);        
      });	
    });
})(jQuery);	