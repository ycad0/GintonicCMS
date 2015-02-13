/*
    Gintonic Web
    Author:    Philippe Lafrance
    Link:      http://gintonicweb.com
*/

requirejs.config({

    baseUrl: '/js/',
    urlArgs: "bust=56",
    
    paths: {
        app:        '/js/app',
        basepath:   baseUrl+'GtwRequire/js/basepath',
        
        // Gtw Plugins
        ui:     baseUrl+'GtwUi/js',
        users:  baseUrl+'GtwUsers/js',
        //contact:'/GtwContact/js',
        files:  baseUrl+'/GtwFiles/js',
        
        // Libs
        jquery:             '//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min',
        bootstrap:          '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min',                             
        jqueryvalidate:     '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min',        
        jquerycalendar:     baseUrl+'GtwUi/js/bootstrap-datetimepicker',
        bootstrapwysiwyg:     baseUrl+'GtwUi/js/wysiwyg',
        bootstrapwysiwygHtml:     baseUrl+'GtwUi/js/bootstrap-wysihtml'
    },
    
    shim: {
        bootstrap : ["jquery"],
        jqueryvalidate : ["jquery"],        
        jquerycalendar : ["jquery"],        
        bootstrapwysiwygHtml : ["jquery"]
        
    },
    
    optimize: "none"
    
});
