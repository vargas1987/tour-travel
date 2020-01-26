jQuery(function ($) {
    $(document).ready(function () {
        var $collectionHolder = $('div.contact-list');
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        $collectionHolder.on('click', 'a.delete', function(e) {
            e.preventDefault();

            $(this).closest('.hotel-contact-container').remove();

            return false;
        });

        $(document).on('click', 'a[data-type="add-hotel-contact"]', function(e) {
            e.preventDefault();

            addHotelContactForm($collectionHolder);
        });

        function addHotelContactForm($collectionHolder) {
            var prototype = $collectionHolder.data('prototype');
            var index = $collectionHolder.data('index');
            var hotelContactForm = prototype.replace(/__name__/g, index);

            $collectionHolder.data('index', index + 1);
            $(hotelContactForm).insertBefore($collectionHolder.find('.btn-holder'));

            $collectionHolder.find('select').each(function() {
                $(this).selectmenu();
            });
        }
    });
});