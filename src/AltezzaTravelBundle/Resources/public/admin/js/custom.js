Date.shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

function shortMonths(dt)
{
    return Date.shortMonths[dt.getMonth()];
}

jQuery(function ($) {
    $('input').filter(':not([type="radio"])').on('input keyup paste', function (event) {
        this.value = this.value.replace(/[а-яА-ЯёЁ]/g, '');
    });
    $('.age-block-holder input, .meal-plans-list input, .default-price-table input, .admin-price-table input').filter(':not([type="radio"])').on('input keyup paste', function (event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    var dirty = false;

    $(document).on('change', 'form[data-behaviour="beforeunload"] *:input', function () {
        dirty = true;
    });
    $(document).on('click', '.btn-delete-hotel', function () {
        dirty = false;
    });
    $(document).on('submit', 'form[data-behaviour="beforeunload"]', function () {
        dirty = false;
    });

    $(window).bind('beforeunload', function (event) {
        if (dirty === true) {
            event.preventDefault();

            return 'The changes you have made may not be saved.';
        }
    });

    $.extend({ alert: function (message, title) {
            $("<div></div>").dialog( {
                buttons: { "Ok": function () { $(this).dialog("close"); } },
                close: function (event, ui) { $(this).remove(); },
                resizable: false,
                title: title,
                modal: true
            }).text(message);
        }
    });
});
