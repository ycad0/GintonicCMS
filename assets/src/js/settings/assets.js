define(function(require) {

    var $ = require("jquery");

    $('[data-npm]').on('click', function () {
        var $btn = $(this).button('loading')
        $.ajax({
            // todo: use relative path
            url: '/gintonic_c_m_s/settings/nodeInstall.json',
            success: function (data) {
                var response = data['response']
                $btn.button('reset')
                if(!response['errCode']){
                    $('[data-bower]').removeClass('disabled');
                    $('[data-npm-status]').removeClass('label-default');
                    $('[data-npm-status]').addClass('label-primary');
                } else {
                    $('[data-npm-status]').removeClass('label-default');
                    $('[data-npm-status]').addClass('label-danger');
                }
                $('[data-npm-status]').text(response['errCode']?'error':'installed');
            }
        });
    });
    
    $('[data-bower]').on('click', function () {
        var $btn = $(this).button('loading')
        $.ajax({
            // todo: use relative path
            url: '/gintonic_c_m_s/settings/bowerInstall.json',
            success: function (data) {
                var response = data['response'];
                $btn.button('reset')
                if(!response['errCode']){
                    $('[data-grunt]').removeClass('disabled');
                    $('[data-bower-status]').removeClass('label-default');
                    $('[data-bower-status]').addClass('label-primary');
                } else {
                    $('[data-bower-status]').removeClass('label-default');
                    $('[data-bower-status]').addClass('label-danger');
                }
                $('[data-bower-status]').text(response['errCode']?'error':'installed');
            }
        });
    });
    
    $('[data-grunt]').on('click', function () {
        var $btn = $(this).button('loading')
        $.ajax({
            // todo: use relative path
            url: '/gintonic_c_m_s/settings/grunt.json',
            success: function (data) {
                var response = data['response'];
                $btn.button('reset')
                if(!response['errCode']){
                    $('[data-done]').removeClass('disabled');
                    $('[data-grunt-status]').removeClass('label-default');
                    $('[data-grunt-status]').addClass('label-primary');
                } else {
                    $('[data-grunt-status]').removeClass('label-default');
                    $('[data-grunt-status]').addClass('label-danger');
                }
                console.log(response);
                console.log(response['errCode']);
                console.log(response['errCode']?'error':'installed');
                $('[data-grunt-status]').text(response['errCode']?'error':'installed');
            }
        });
    });
});
