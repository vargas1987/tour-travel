$(document).ready(function() {
    $(document).on('click', 'a[data-behavior="remove-room"]', function(e) {
        e.preventDefault();

        $(this).parent().remove();

        return false;
    });

    $(document).on('click', 'a[data-behavior="add-room"]', function(e) {
        e.preventDefault();

        var $collectionHolder = $(this).closest('.room-block-holder');
        $collectionHolder.data('index', $collectionHolder.find(':input').length);

        addRoomForm($collectionHolder);
    });

    $(document).on('selectmenuchange', '[data-behaviour="select-room-type"]', function(event, ui) {
        var prototype = $(ui.item.element).data('room-type-prototype');
        var prototypeName = $(ui.item.element).closest('select').attr('name');
        prototypeName = prototypeName.replace('[roomType]', '');
        prototype = prototype.replace(/accommodations/g, prototypeName + '[accommodations]');

        $(ui.item.element).closest('.room-block-inner').find('[data-behaviour="room-type-inner"]').html(prototype);
    });

    function addRoomForm($collectionHolder) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var roomForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $collectionHolder.data('index', index + 1);

        $(roomForm).insertBefore($collectionHolder.find('.btn-holder'));

        $collectionHolder.find('select').each(function() {
            $(this).selectmenu();
        });
    };
});
