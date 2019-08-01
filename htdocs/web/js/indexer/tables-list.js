$(document).ready(function () {
    $('#projects').click(function () {
        line($(this));
        _hashState('#projects');
        $('#projectsPanel').show();
        $('#tablesPanel').hide();
        $('#filedsPanel').hide();
    });
    $('#tables').click(function () {
        line($(this));
        _hashState('#tables');
        $('#projectsPanel').hide();
        $('#tablesPanel').show();
        $('#filedsPanel').hide();

    });
  $('#fileds').click(function () {
        line($(this));
        _hashState('#fileds');
      $('#projectsPanel').hide();
      $('#tablesPanel').hide();
      $('#filedsPanel').show();

    });


    var line = function (obj) {
        var w = obj.width();
        var p = obj.position().left;
        var el = $('.lsfw-line ');
        $('.lsfw-tab').removeClass('active');
        obj.addClass('active');
        el.clearQueue().animate({
            left: p,
            width: w
        }, 300);
    };

    var _hashState = function (_hash) {
        if (history.pushState) {
            history.pushState(null, null, _hash);
        }
        else {
            location.hash = _hash;
        }
    };


    if (!window.location.hash)
        $('.periodic-tab.active').first().click();
    else
        $(window.location.hash).click();

    $(window).bind('hashchange', function () {
        $(window.location.hash).click();
    });

    $(document).on('click', '.js-table-fields', function() {
        var t = $(this).text().trim();
        $('#fileds').click();
        $('#columnNameFilter').val(t).trigger('keyup');
    });
});
