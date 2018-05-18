class Popup {
    constructor() {
        this.init();
    }

    init() {
        this.successful();
    }

    successful() {

        let top = ($(window).innerHeight() / 2);
        let left = ($(window).innerWidth() / 2);
        let windowWidth = $(window).innerWidth();

        $('#popupGeneral').on('shown.bs.modal', function () {

            let contentWidth = $(this).find(`.modal-content`).innerWidth();
            let contentHeight = $(this).find(`.modal-content`).innerHeight();
            let imgHeight1 = $(this).find(`#p1>img`).data().height;
            let imgHeight3 = $(this).find(`#p3>img`).data().height;
            let imgHeight4 = $(this).find(`#p4>img`).data().height;

            $('#p1').animate({
                top: windowWidth > 1024 ? (top - contentHeight - 0.25 * imgHeight1).toString() : (top - contentHeight) + 'px',
                left: windowWidth > 1024  ? (left - contentWidth).toString() : (0). toString() + 'px',
                zIndex:  -1
            }, 'linear', function () {
                $(this).addClass('p-success');
            });

            $('#p2').animate({
                top:  windowWidth > 1024 ? (top - contentHeight * 0.5).toString() : (top + 0.5*contentHeight ) + 'px',
                left: windowWidth > 1024  ? (left - 0.5 * contentWidth).toString(): (0). toString() + 'px',
                zIndex: -1
            }, 300, 'linear', function () {
                $(this).addClass('p-success');
            });

            $('#p3').animate({
                top: windowWidth > 1024 ? (top - contentHeight - 0.25 * imgHeight3).toString() : (top - contentHeight) + 'px',
                left: windowWidth > 1024  ? (left + 0.2 * contentWidth).toString() : (left).toString() + 'px',
                zIndex: -1
            }, 400, 'linear', function () {
                $(this).addClass('p-success');
            });

            $('#p4').animate({
                top: windowWidth > 1024 ? (top + contentHeight / 2 - 0.5 * imgHeight4).toString() : (top + 0.5*contentHeight )  + 'px',
                left: windowWidth > 1024  ? (left + 0.2 * contentWidth).toString() : (left).toString() + 'px'
            }, 500, 'linear', function () {
                $(this).addClass('p-success');
            });

        });

        $('#popupGeneral').on('hide.bs.modal', function () {
            $(this).find('.p-animate').each(function () {
                $(this).animate({
                    top: top*2,
                    left: left
                }, function () {
                    $(this).removeClass('p-success');
                });
            })
        });
    }
}

export default Popup;