define(function(require) {

    var $ = require("jquery");

    $('[data-npm]').on('click', function () {
        var $btn = $(this).button('loading')
        $.ajax({
            // todo: use relative path
            url: '/gintonic_c_m_s/settings/nodeInstall.json',
            success: function (response) {
                data = JSON.parse(response);
                $btn.button('reset')
                if(data['status'] == 'success'){
                    $('[data-bower]').removeClass('disabled');
                    $('[data-npm-status]').removeClass('label-default');
                    $('[data-npm-status]').addClass('label-success');
                } else {
                    $('[data-npm-status]').removeClass('label-default');
                    $('[data-npm-status]').addClass('label-danger');
                }
                $('[data-npm-status]').text(data['status']);
            }
        });
    });
    
    $('[data-bower]').on('click', function () {
        var $btn = $(this).button('loading')
        $.ajax({
            // todo: use relative path
            url: '/gintonic_c_m_s/settings/bowerInstall.json',
            success: function (response) {
                data = JSON.parse(response);
                $btn.button('reset')
                if(data['status'] == 'success'){
                    $('[data-grunt]').removeClass('disabled');
                    $('[data-bower-status]').removeClass('label-default');
                    $('[data-bower-status]').addClass('label-success');
                } else {
                    $('[data-bower-status]').removeClass('label-default');
                    $('[data-bower-status]').addClass('label-danger');
                }
                $('[data-bower-status]').text(data['status']);
            }
        });
    });
    
    $('[data-grunt]').on('click', function () {
        var $btn = $(this).button('loading')
        $.ajax({
            // todo: use relative path
            url: '/gintonic_c_m_s/settings/grunt.json',
            success: function (response) {
                data = JSON.parse(response);
                $btn.button('reset')
                if(data['status'] == 'success'){
                    $('[data-build-success]').removeClass('hidden');
                    $('[data-grunt-status]').removeClass('label-default');
                    $('[data-grunt-status]').addClass('label-success');
                } else {
                    $('[data-grunt-status]').removeClass('label-default');
                    $('[data-grunt-status]').addClass('label-danger');
                }
                $('[data-grunt-status]').text(data['status']);
            }
        });
    });
});
