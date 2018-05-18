import Form from './form';

class SignUp extends Form {
    constructor($form) {
        super($form);
        this.dateTimePicker();
        this.setDatePickerPosition();
    }

    dateTimePicker() {
        let datepicker_settings = {
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: "-100:+0"
        };

        $('.page-template-template-signup #user_dob').datepicker(datepicker_settings);
        $('.woocommerce-account #user_dob').datepicker(datepicker_settings);
    }

    setDatePickerPosition(){
        let $datePicker =  $('.page-template-template-signup #user_dob');
/*        $datePicker.datepicker( 'option' , 'onSelect', function() {
            $(this).trigger('blur');

        } );*/
        $datePicker.on('focus',function (e) {
            let windowWidth = $(window).width();
            let p = parseInt(jQuery('.page-template-template-signup #user_dob').next('p').css('marginBottom'))*0.25;
            let topDatepicker = windowWidth > 1024 ? windowWidth >= 1440 ?  $(this).offset().top - $(this).outerHeight() + p : $(this).offset().top - $(this).outerHeight() : $(this).offset().top - $(this).outerHeight();
            let left = windowWidth > 1024 ? ($(this).offset().left)/2 : $(this).offset().left;
            $('.page-template-template-signup #ui-datepicker-div').css({
                top: topDatepicker,
                left: left,
            });
        });

        $('.woocommerce-account #user_dob').on('focus',function (e) {
            let windowWidth = $(window).width();
            let body_margin = parseInt($('body').css('margin-top')) + parseInt($('html').css('margin-top'));
            let topDatepicker = parseInt($(this).offset().top) + parseInt($(this).outerHeight()) - body_margin;
            let left = windowWidth > 1024 ? ($(this).offset().left)/2 : $(this).offset().left;
            $('.woocommerce-account #ui-datepicker-div').css({
                top: topDatepicker,
                left: left,
            });
        });                
    }
}

export default SignUp;