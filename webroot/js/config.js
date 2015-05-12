requirejs.config({
    baseUrl: '/gintonic_c_m_s/',
    urlArgs: "bust=0",
    paths: {
        // Base Paths
        app: 'js/app',
        lib: 'js/lib',
        gintonic:   'js',

        // GintonicCMS utilities
        stripe: 'js/stripe',
        messages: 'js/messages',
        albums: 'js/albums',
        users: 'js/users',
        admin: 'js/admin',
        files:  'js/files',
        
        // GintonicCMS dependencies
        wysiwyg: 'js/lib/bootstrap-wysiwyg',
        
        // Libs
        jquery: '//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min',
        bootstrap: '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min',
        jqueryvalidate: '//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min',
        slimscroll: '//cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.3/jquery.slimscroll.min',
        prettify: '//cdn.rawgit.com/google/code-prettify/master/loader/run_prettify'
    },
    
    shim: {
        slimscroll :  {
            deps: ["jquery"],
            exports: 'slimscroll'
        },
        bootstrap : ["jquery"],
        jqueryvalidate : ["jquery"],
        wysiwyg : ["jquery"],
        stripe : ["jquery"]
    }
});
