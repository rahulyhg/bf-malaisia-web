const $delay = 300;

class Slider {
    constructor($el, $options) {
        this.owlEl = $el;
        this.options = $options;
        if (this.options) {
            this.nav = this.owlEl.find(".owl-nav >span");
            this.prev = this.owlEl.find(".owl-prev");
            this.next = this.owlEl.find(".owl-next");
            this.options.navNode = this.nav;
            this.options.prevNode = this.prev;
            this.options.nextNode = this.next;
            this.init();
        }
    }

    init() {
        this.init_owlCaroysel();
        this.owl_prev();
        this.owl_next();
    }

    init_owlCaroysel() {
        this.owlEl.owlCarousel(this.options);
    }

    owl_prev() {
        this.prev.click(() => {
            this.owlEl.trigger('prev.owl.carousel');
        });
    }

    owl_next() {
        this.next.click(() => {
            this.owlEl.trigger('next.owl.carousel');
        });
    }

    owl_resize() {
        setTimeout(() => {
            this.owlEl.trigger('destroy.owl.carousel');
            this.owlEl.html(this.owlEl.find('.owl-stage-outer').html()).removeClass('owl-loaded');
            this.init_owlCaroysel();
            this.owl_popup();
        }, $delay);
    }

    owl_popup() {
        let self = this;
        this.item = this.owlEl.find(".owl-item");
        this.item.click(function () {
            let img = $(this).find('.owl-img').html();
            let description = $(this).find('.owl-desc').html();
            let name = $(this).find('.owl-name .name').html();
            let summary = $(this).find('.owl-name h5').html();
            self.owl_modal_popup(img, description, name, summary);
        });
    }

    owl_modal_popup(data, description, name, summary) {
        let $popupWinner = $('#popupWinner');
        let max_height = $popupWinner.find('.text-scroll').css('max-height');

        $popupWinner.find('.text-scroll').slimScroll({
            height: parseInt(max_height),
            railVisible: true,
            color: '#c2171d'
        }).trigger('mouseenter');

        $popupWinner.find('.modal-body .winner-img').html(data);
        $popupWinner.find('.modal-body .winner-description .text-scroll').html(description);
        $popupWinner.find('.modal-body .detail-add .name-popup').html(name);
        $popupWinner.find('.modal-body .detail-add .summary-popup').html(summary);
        $popupWinner.modal('show');
    }
}

export default Slider;