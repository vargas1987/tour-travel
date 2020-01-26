$(document).ready(function() {
    var seasonsFormName = window.seasonsFormName;
    var seasonTypeFormName = window.seasonTypeFormName;

    var defaultDate = new Date();
    var $collectionHolder = $('ul.season-years-list');
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $collectionHolder.on('click', 'a.delete', function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });

    $(document).on('click', '.delete-year', function(e) {
        e.preventDefault();

        var currentYear = $(this).closest('li[data-year]').data('year');
        var lastYear = $('ul.season-years-list').find('li[data-year]').last().data('year');

        if (currentYear !== lastYear) {
            var title = 'Alert';
            var message = 'You can not remove current year. Before remove next year.';

            $("<div></div>").dialog( {
                buttons: { "Ok": function () { $(this).dialog("close"); } },
                close: function (event, ui) { $(this).remove(); },
                resizable: false,
                title: title,
                modal: true
            }).text(message);

            return;
        }

        $(this).closest('li[data-year]').remove();

        return false;
    });

    $(document).on('click', 'a[data-type="add-season"]', function(e) {
        e.preventDefault();

        var year = parseInt($(this).data('year'));
        addSeasonForm($collectionHolder, year);
    });

    $(document).on('click', 'a[data-type="add-year"]', function(e) {
        e.preventDefault();

        var lastYearSeason = $collectionHolder.find('li[data-year]').last();

        if (lastYearSeason.length > 0 && lastYearSeason.find('.season-list li').length < 1) {
            var title = 'Alert';
            var message = 'You can not add next year. Add at least one season to previous year';

            $("<div></div>").dialog( {
                buttons: { "Ok": function () { $(this).dialog("close"); } },
                close: function (event, ui) { $(this).remove(); },
                resizable: false,
                title: title,
                modal: true
            }).text(message);

            return;
        }

        var type = $(this).data('behaviour');
        var year = lastYearSeason.length > 0 ? lastYearSeason.data('year') : (new Date()).getFullYear() - 1;

        addYearForm($collectionHolder, year, type);
        $collectionHolder = $('ul.season-years-list');
    });

    function addYearForm($collectionHolder, year, type) {
        var prototype = $collectionHolder.data('year-prototype');
        var yearForm = prototype.replace(/__year__/g, parseInt(year + 1));
        $collectionHolder.append(yearForm);

        if (type === 'same-season') {
            $collectionHolder.find('li[data-year="'+year+'"] ul.season-list li').each(function (key, li) {
                addSeasonForm($collectionHolder, parseInt(year + 1));

                var dateFromValue = $(li).find('[data-type="date-from"]').val().replace(year, parseInt(year + 1));
                var dateToValue = $(li).find('[data-type="date-to"]').val().replace(year, parseInt(year + 1));
                var seasonValue = $(li).find('[data-type="season"]').val();

                var season = $collectionHolder.find('li[data-year="'+parseInt(year + 1)+'"] ul.season-list li').last();

                $(season).find('[data-type="date-from"]').val(dateFromValue);
                $(season).find('[data-type="date-to"]').val(dateToValue);
                $(season).find('[data-type="season"]').val(seasonValue).selectmenu('refresh');
            })
        }

        initSeasonsAccordion();
    }

    function addSeasonForm($collectionHolder, year) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var seasonForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);
        $collectionHolder.find('li[data-year="'+year+'"] ul.season-list').append(seasonForm);

        $collectionHolder.find('input.date').each(function() {
            var format = $(this).data('format') || "d M yy";
            $(this).datepicker({
                hideIfNoPrevNext: true,
                dateFormat: format,
                yearRange: year+':'+year,
                defaultDate: defaultDate.getDate() + ' ' + shortMonths(defaultDate) + ' ' + year
            });

            // updateInputMask();
        });

        $collectionHolder.find('select').each(function() {
            $(this).selectmenu();
        });
    }

    $collectionHolder.find('input.date').each(function() {
        var format = $(this).data('format') || "d M yy";
        var year = $(this).parent('li[data-year]').data('year');
        $(this).datepicker({
            hideIfNoPrevNext: true,
            dateFormat: format,
            yearRange: year+':'+year,
            defaultDate: defaultDate.getDate() + ' ' + shortMonths(defaultDate) + ' ' + year
        });

        // updateInputMask();
    });
});
