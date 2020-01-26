$(document).ready(function() {
    var seasonsFormName = window.seasonsFormName;
    var seasonTypeFormName = window.seasonTypeFormName;

    var $collectionHolder = $('ol.season-names-list');

    $(document).on('click', 'ol.season-names-list a.delete', function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });

    $(document).on('click', 'form[name="'+seasonsFormName+'"] button[type="submit"]', function(e) {
        $(this).closest('form').find('li[data-year]:not(.open)').find('.season-years-heading').trigger('click');

        var seasonTypeForm = $('form[name="'+seasonTypeFormName+'"]');
        updateSeasonTypes(seasonTypeForm).then(function () {
            if (!validateForm()) {
                return false;
            }
        }).catch(function (error) {
            return false;
        });
    });

    var validateForm = function () {
        var isValid = true;
        var $seasonCollectionHolder = $('ul.season-years-list');

        $($seasonCollectionHolder).find('input').each(function (key, input) {
            if (!$(input).val()) {
                $(input).closest('.input-holder').addClass('ui-state-error');
                $(input).closest('li[data-year]:not(.open)').find('.season-years-heading').trigger('click');
                isValid = false;
            } else {
                $(input).closest('.input-holder').removeClass('ui-state-error');
            }
        });
        $($seasonCollectionHolder).find('select').each(function (key, select) {
            var selectId = '#' + $(select).attr('id') + '-button';
            if (!$(select).val()) {
                $(selectId).addClass('ui-state-error');
                $(selectId).closest('li[data-year]:not(.open)').find('.season-years-heading').trigger('click');
                isValid = false;
            } else {
                $(selectId).removeClass('ui-state-error');
            }
        });

        return isValid;
    };

    $(document).on('click', 'form[name="'+seasonTypeFormName+'"] button[type="submit"]', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        updateSeasonTypes(form);
    });

    var updateSeasonTypes = function(form) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: $(form).attr('action'),
                method: 'post',
                data:$(form).serialize(),
                async: false,
                dataType: 'json',
                success: function (response) {
                    if (response.status !== 'ok') {
                        reject(response.errors);
                    }

                    $('form[name="'+seasonTypeFormName+'"]').html($(response.season_type_form).html());
                    $collectionHolder = $('ol.season-names-list');

                    var $seasonCollectionHolder = $('ul.season-years-list');
                    $seasonCollectionHolder.data('prototype', response.season_form_prototype);

                    let select = document.createElement('select');
                    $("<option value=''>------</option>").appendTo(select);

                    $.each(response.season_types, function(index, itemData) {
                        $("<option value='" + itemData.type + "'>" + itemData.title
                            + "</option>").appendTo(select);
                    });

                    $('form[name="'+seasonsFormName+'"]').find('[data-type="season"]').each(function (key, selectmenu) {

                        $(selectmenu).selectmenu('disable');
                        let previousValue = $(selectmenu).val();

                        $(selectmenu).html($(select).html());

                        if ($(selectmenu).find('option[value="' + previousValue + '"]').length !== 0) {
                            $(selectmenu).val(previousValue);
                        } else {
                            $(selectmenu).val($(selectmenu).find('option').first().val());
                        }

                        $(selectmenu).selectmenu("refresh");
                        $(selectmenu).selectmenu('enable');
                    });

                    resolve();
                },
                error: function (error) {
                    reject(error)
                }
            });
        });
    };

    $(document).on('click', 'a[data-type="add-season-type"]', function(e) {
        e.preventDefault();

        addSeasonTypeForm($collectionHolder);
    });

    function addSeasonTypeForm($collectionHolder) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var seasonTypeForm = prototype.replace(/__name__/g, index);

        $collectionHolder.data('index', index + 1);
        $collectionHolder.append(seasonTypeForm);
    }
});