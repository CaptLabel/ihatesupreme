$(document).ready(function () {
    var $container = $('div#defaultbundle_serie_goings');
    var $addLink = $('<a href="#" id="add_category" class="btn btn-default">Add adress</a>');
    $container.append($addLink);
    $addLink.click(function (e) {
        addCategory($container);
        e.preventDefault();
        return false;
    });
    var index = $container.find(':input').length;
    if (index == 0) {
        addCategory($container);
    } else {
        $container.children('div').each(function () {
            addDeleteLink($(this));
        });
    }
    function addCategory($container) {
        var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Adress n°' + (index + 1))
            .replace(/__name__/g, index));
        addDeleteLink($prototype);
        $container.append($prototype);
        index++;
    }
    function addDeleteLink($prototype) {
        $deleteLink = $('<a href="#">Remove</a>');
        $prototype.append($deleteLink);
        $deleteLink.click(function (e) {
            $prototype.remove();
            e.preventDefault();
            return false;
        });
    }
});
