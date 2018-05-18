var Profile = Profile || {};
(function( $ ) {
    Profile = {
        bootstrap : function(){
            this.edit();
            this.editPassword();
            this.editBillingAddress();
            this.editShippingAddress();
            this.clickTab();
            this.showOdermobile();
            this.showInfomationmobile();
            this.scrollUser();
        },

        edit : function () {
            $("u").click(function () {
                $(this).prev().remove();
                $(this).next('input').focus();
            })
        },
        editPassword : function () {
            $(".password").click(function () {
                $(this).next().removeAttr('disabled');
                $(".edit-pw").slideDown();
            })
        },
        editBillingAddress : function () {
            $(".billing-address-click").click(function () {
                $(this).next().removeAttr('disable');
                $(".billing-address-detail").slideDown();
            })
        },
        editShippingAddress : function () {
            $(".shipping-address-click").click(function () {
                $(this).next().removeAttr('disable');
                $(".shipping-address-detail").slideDown();
            })
        },

        clickTab : function () {
            let hash = window.location.hash;            
            if($(".myaccount").length > 0){                
                if(hash.length > 0){
                    if(hash == '#information-tab'){
                        let tab_href = hash.replace("-tab","");
                        $('.myaccount .nav-link[href="' + tab_href + '"]').trigger('click');
                    }
                }
                // $(".nav-link")
                $(".myaccount .nav-link").click(function () {                    
                    window.location.hash = $(this).attr('href') + '-tab';
                });
            }
        },

        showOdermobile : function () {
            $(".tab-order-mobile").click(function () {
                if($(this).next().css('display') === 'none'){
                    $(this).next().slideDown();
                    $(".box").css('display','block');
                    $(this).css('color','#fcd307');
                    $(this).css('background','#ba161c');
                    $(".tab-order-mobile .icon-up").css('display','none');
                    $(".tab-order-mobile .icon-down").css('display','block');
                }else {
                    $(".box").css('display','none');
                    $(this).next().slideUp();
                    $(this).css('color','#ba161c');
                    $(this).css('background','#fcd307');
                    $(".tab-order-mobile .icon-up").css('display','block');
                    $(".tab-order-mobile .icon-down").css('display','none');
                }

            })
        },

        showInfomationmobile : function () {
            $(".tab-informaton-mobile").click(function () {
                if($(this).next().css('display') === 'none') {
                    $(this).next().slideDown();
                    $(this).css('color','#fcd307');
                    $(this).css('background','#ba161c');
                    $(".tab-informaton-mobile .icon-up").css('display','none');
                    $(".tab-informaton-mobile .icon-down").css('display','block');
                }else {
                    $(this).next().slideUp();
                    $(this).css('color','#ba161c');
                    $(this).css('background','#fcd307');
                    $(".tab-informaton-mobile .icon-up").css('display','block');
                    $(".tab-informaton-mobile .icon-down").css('display','none');
                }
            })
        },
        scrollUser : function () {
            $(".content-order").slimScroll({height: '400px',size: '0px'});
        }
    }
})(jQuery);

export default Profile;
