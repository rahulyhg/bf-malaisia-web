var Dialog = Dialog || {};
(function( $ ) {
    Dialog = {
        bootstrap : function(){            
            this.closePopup();
            this.popupHandle();
        },
        popupHandle: function(){
            $('.dialog-trigger').click(function(event){
                event.preventDefault();
                if( $($(this).attr('data-target')).length > 0 ){
                    $($(this).attr('data-target')).modal('show');
                }
            });            
        },
        closePopup: function () {
            $(".close-popup").click(function () {
                $("#popup").hide();
            })
        }

    }
})(jQuery);

export default Dialog;
