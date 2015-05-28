define(["jquery"], function (e) {

    var $ = require("jquery");

    $('[data-install-kit]').on('click', function () {
        url = $(this).data('src');
        $('#install-kit').removeClass('hidden');
        $(this).addClass('hidden');
        that = $(this);
        $.ajax({
            url: url,
            success: function (response) {
                $('#install-kit').addClass('hidden');
                that.removeClass('hidden');
                that.addClass('btn-success');
                that.attr('value', 'Done');
                $('[data-download-kit]').removeClass('disabled');
            }
        });
    });
    
    $('[data-download-kit]').on('click', function () {
        url = $(this).data('src');
        console.log(url);
        $('#download-kit').removeClass('hidden');
        $(this).addClass('hidden');
        that = $(this);
        $.ajax({
            url: url,
            success: function (response) {
                $('#download-kit').addClass('hidden');
                that.removeClass('hidden');
                that.addClass('btn-success');
                that.attr('value', 'Done');
                $('[data-grunt]').removeClass('disabled');
            }
        });
    });
    
    $('[data-grunt]').on('click', function () {
        url = $(this).data('src');
        console.log(url);
        $('#grunt').removeClass('hidden');
        $(this).addClass('hidden');
        that = $(this);
        $.ajax({
            url: url,
            success: function (response) {
                $('#grunt').addClass('hidden');
                that.removeClass('hidden');
                that.addClass('btn-success');
                that.attr('value', 'Done');
            }
        });
    });
});