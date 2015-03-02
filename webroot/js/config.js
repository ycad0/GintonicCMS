/*
    Gintonic Web
    Author:    Philippe Lafrance
    Link:      http://gintonicweb.com
*/
requirejs.config({
    baseUrl: '/js/',
    urlArgs: "bust=56",
    paths: {
        basepath:   baseUrl+'gintonic_c_m_s/js/require/basepath',
        app:        baseUrl+ 'gintonic_c_m_s/js/app',
        
        //Gtw lib 
        lib: baseUrl+'gintonic_c_m_s/js/lib',
        
        //Gtw Users
        users: baseUrl+'gintonic_c_m_s/js/users',
        
        //Gtw Admin
        admin: baseUrl+'gintonic_c_m_s/js/admin',
        
        //Gtw Admin
        message: baseUrl+'gtw_message/js/',
        
        // Gtw Files
        files:  baseUrl+'gintonic_c_m_s/js/files',
        
        // wysiwyg
        wysiwyg: baseUrl + 'gintonic_c_m_s/js/lib/bootstrap-wysiwyg',
        
        // Libs
        jquery:             '//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min',
        bootstrap:          '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min',
        jqueryvalidate:     '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min',
    },
    
    shim: {
        bootstrap : ["jquery"],
        jqueryvalidate : ["jquery"],
        wysiwyg : ["jquery"],
    },   
    optimize: "none"    
});
