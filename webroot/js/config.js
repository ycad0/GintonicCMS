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
        
        //Gtw Users
        users: baseUrl+'gintonic_c_m_s/js/users',
        
        //Gtw Admin
        admin: baseUrl+'gintonic_c_m_s/js/admin',
        
        // Gtw Files
        files:  baseUrl+'gintonic_c_m_s/js/files',
        
        // Libs
        jquery:             '//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min',
        //bootstrap:          '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min',                             
        bootstrap:          '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min',
        jqueryvalidate:     '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min',        
    },
    
    shim: {
        bootstrap : ["jquery"],
        jqueryvalidate : ["jquery"],
    },   
    optimize: "none"    
});
