const EMAIL_REGEX = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+")){2,}@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]{2,}\.)+[a-zA-Z]{2,}))$/;

const PHONE_NUMBER_10 = /^0(\d){9}$/;

const PHONE_NUMBER_11 = /^0(\d){10}$/;

const DATE = /^[\d]{2}[/][\d]{2}[/][\d]{4}$/;

const INVALID_CLASS = 'invalidClass';

const SIGNUP_MESSAGES = Object.assign(sign_up_messages);

function smoothScrollToElement(selector, pos_buffer) {
    let $el = $(selector);
    let scroll = $el.offset().top - $el.outerHeight() - $('header').height();
    if ($el.length > 0) {
        $('html, body').stop()
            .animate({scrollTop: scroll}, 500, function () {
                //$(this).find($el).focus();
            });
    }
}

class Form {
    constructor($form) {
        this.form = $form;
        this.submit();
        this.initErrorMessages();
    }

    initErrorMessages() {
        this.form.find('input[data-required]').each(function () {
            $(this).data('required', SIGNUP_MESSAGES[`${$(this).attr('name')}`].required);
            $(this).data('format', SIGNUP_MESSAGES[`${$(this).attr('name')}`].format);
        });
    }

    validator($el, $type) {
        switch ($type) {
            case 'email':
                return EMAIL_REGEX.test($el.value);
                break;
            case 'phone':
                return PHONE_NUMBER_10.test($el.value) || PHONE_NUMBER_11.test($el.value);
                break;
            case 'checkbox':
                return $el.checked === true;
                break;
            case 'password':
                return $el.value.length >= 6;
                break;
            case 'date':
                return DATE.test($el.value) && this.checkAge($el.value);
            default:
                return $el.value !== '';
                break;
        }
    }

    checkAge($val) {
        let time = $val.split('/');
        let present = new Date();
        if (parseInt(time[2]) > 1900 && parseInt(time[1]) > 0 && parseInt(time[0]) > 0) {
            if (present.getFullYear() - parseInt(time[2]) > 18) {
                return true;
            } else if (present.getFullYear() - parseInt(time[2]) === 18) {
                if (((present.getMonth() + 1) - parseInt(time[1])) > 0) {
                    return (present.getDate() - parseInt(time[0])) <= 0;
                } else if (((present.getMonth() + 1) - parseInt(time[1])) === 0) {
                    return ((present.getDate() + 1) - parseInt(time[0])) >= 0;
                } else {
                    return false;
                }
            }
        }

        return false;
    }

    checkValid(func) {
        $(this).next('.invalid-messages').empty();
        $(this).removeClass(INVALID_CLASS);
        if ($(this).val() !== '' && $(this).attr('type') !== 'checkbox') {
            if (func) {
                return true;
            } else {
                $(this).addClass(INVALID_CLASS);
                //call message
                $(this).next('.invalid-messages').append($(this).data('format'));
                return false;
            }
        } else if ($(this).attr('type') === 'checkbox') {
            !func && $(this).next('.invalid-messages').append($(this).data('required'));
            return func;
        } else if ($(this).data('validate') === 'email' && $(this).val() === '') {
            return true
        } else {
            $(this).next('.invalid-messages').append($(this).data('required'));
        }
        return false;
    }

    focusEl(){
        $(this).on('touchstart', function() {
            $(this).closest('.group-sub').find('label').click();
            $(this).focus();
        });
    }

    submit() {
        let self = this;

        this.form.on('submit', (events) => {
            let valid_fields = true;
            let elError = [];
            events.preventDefault();
            events.stopPropagation();
            this.form.find('input[data-validate]').each(function () {
                valid_fields &= self.checkValid.call(this, self.validator(this, $(this).data('validate')));
                !self.checkValid.call(this, self.validator(this, $(this).data('validate'))) && elError.push(this);
            });

            let firstElError = $(elError[0]).attr('id');
            if (valid_fields) {
                $.fn.ajaxPost('action=bf_signup&' + $(this.form).serialize(), function () {
                    setTimeout(function () {
                        location.href = $('#registerform').attr('data-redirect');
                    }, 3000);
                }, function () {
                    smoothScrollToElement('.block-signup .bf-title', 0);
                });
                return;
            } else {
                $(`.block-signup #${firstElError}`).trigger('touchstart', this.focusEl.call(`.block-signup #${firstElError}`));

                smoothScrollToElement(`.block-signup #${firstElError}`, 0);
            }
        });
    }
}

export default Form;