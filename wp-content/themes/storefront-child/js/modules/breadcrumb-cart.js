let Breadcrumb = Breadcrumb || {};
const bBlock = $('.breadcrumb-cart');
const cart = $(bBlock).find('.cart');
const billing = $(bBlock).find('.billing');
const confirm = $(bBlock).find('.thank-you');
const $delay = 300;

(function ($) {
    Breadcrumb = {
        bootstrap: function () {
            setTimeout(() => {
                let bWidth = $(bBlock).innerWidth();
                let cartWidth = $(cart).find('img').innerWidth();
                let billingWidth = $(billing).find('img').innerWidth();
                let confirmWidth = $(confirm).find('img').innerWidth();

                let occupyBlock = bWidth - (cartWidth + billingWidth + confirmWidth) - 1 / 30 * bWidth;
                // $(cart).css("padding-right", () => {
                //     return Math.round(1 / 4 * occupyBlock);
                // });

                // $(billing).css({
                //     "padding-left": () => {
                //         return Math.round(1 / 4 * occupyBlock);
                //     },
                //     "padding-right": () => {
                //         return Math.round(1 / 4 * occupyBlock);
                //     }
                // });

                // $(confirm).css("padding-left", () => {
                //     return Math.round(1 / 4 * occupyBlock);
                // });

            }, $delay);
        }
    }
})(jQuery);

export default Breadcrumb;
