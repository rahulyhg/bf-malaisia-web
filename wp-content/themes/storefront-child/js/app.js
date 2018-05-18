import Cart from "./modules/cart";
import Slider from "./modules/slider";
import Subscription from "./modules/subscription";
import Dialog from "./modules/dialog";
import Navbar from "./modules/navbar";
import Product from "./modules/product";
import Profile from "./modules/profile";
import Game from "./modules/game";
import Popup from "./modules/popup";
import SignUp from "./modules/signup";
import Breadcrumb from "./modules/breadcrumb-cart";
import $ from 'jquery';

let Site = Site || {};
const $bfBanner = $(".bf-banner").find(".owl-carousel");
const $bfWinner = $(".bf-our-winners").find(".owl-carousel");
const $listWinner = $('.block-winner-list');
const $signupForm = $('#registerform');
const $listSponsor = $('.sponsors-list').find('.owl-carousel');

let $bfBannerOption = {
    loop: true,
    stagePadding: 10,
    mouseDrag: true,
    touchDrag: true,
    responsive: {
        0: {
            items: 1,
            margin: 0,
            stagePadding: 0
        },

        768: {
            items: 1,
            margin: 0,
            stagePadding: 0
        },

        1300: {
            items: 1,
            margin: 0,
            stagePadding: 0
        }
    }
};

let $bfWinnerOption = {
    loop: true,
    stagePadding: 10,
    mouseDrag: false,
    touchDrag: true,
    dots: false,
    nav: true,
    responsive: {
        0: {
            items: 1,
            margin: 0,
            stagePadding: 0
        },

        1023: {
            items: 1,
            margin: 0,
            stagePadding: 0
        },

        1024: {
            items: 3,
            margin: 20,
            stagePadding: 0
        }
    }
};

let $bfSponsorOption = {
    loop: false,
    stagePadding: 10,
    mouseDrag: false,
    touchDrag: true,
    dots: false,
    nav: true,
    responsive: {
        0: {
            items: 1,
            margin: 0,
            stagePadding: 0
        },

        1023: {
            items: 1,
            margin: 0,
            stagePadding: 0
        },

        1024: {
            items: 3,
            margin: 20,
            stagePadding: 0
        }
    }

};

export let $success = null;
export let $banner = null;
export let $sub = null;
export let $winnerSlider = null;
export let $winner = null;
export let $signup = null;
export let $sponser = null;

(function ($) {

    Site = {
        //properites
        bootstrap: function () {
            //default events
            //this.scrollEvent();
            //custom events
            this.navigationEvent();
            // modules
            Cart.bootstrap();
            $banner = new Slider($bfBanner, $bfBannerOption);
            $winnerSlider = new Slider($bfWinner, $bfWinnerOption);
            $sponser = new Slider($listSponsor, $bfSponsorOption);
            $winner = new Slider($listWinner, null);
            $success = new Popup();
            $signup = new SignUp($signupForm);
            Breadcrumb.bootstrap();
            Dialog.bootstrap();
            Navbar.bootstrap();
            Product.bootstrap();
            Profile.bootstrap();
            Game.bootstrap();
        },
        scrollEvent: function () {
            $(window).scroll(function () {
                $(window).scrollTop();
            })
        },
        navigationEvent: function () {
        },
        // helpers
        smoothScrollTo: function (pos, callback) {
            $('html, body')
                .animate({scrollTop: pos}, 500)
                .promise()
                .then(function () {
                    // callback code here
                    if (typeof callback === "function") {
                        callback();
                    }
                });
        },
        smoothScrollToElement: function (selector, pos_buffer) {
            if ($(selector).length > 0) {
                var pos = $(selector).offset().top + pos_buffer;
                this.smoothScrollTo(pos, null);
            }
        }
    };
})(jQuery);

$(document).ready(() => {
    Site.bootstrap();
    $sub = new Subscription();
    $winnerSlider.owl_popup();
    $winner.owl_popup();
    $sponser.owl_popup();
});

$(window).resize(() => {
    $winnerSlider.owl_resize();
    $sponser.owl_resize();
    Product.onWindowResize();
    Cart.onWindowResize();
    $sub = new Subscription();
    Breadcrumb.bootstrap();
    $success = new Popup();
    $signup.setDatePickerPosition();
});
