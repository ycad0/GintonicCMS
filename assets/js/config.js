requirejs.config({
    baseUrl: '/',
    urlArgs: 'bust=0',
    paths: {
        // Base Paths
        app: 'js/app',
        lib: 'gintonic_c_m_s/js/lib',
        gintonic: 'gintonic_c_m_s/js',

        // Libs
        react: 'gintonic_c_m_s/js/lib/react/react-with-addons.min',
        JSXTransformer: 'gintonic_c_m_s/js/lib/jsx-requirejs-plugin/JSXTransformer',
        jsx: 'gintonic_c_m_s/js/lib/jsx-requirejs-plugin/jsx',
        text: 'gintonic_c_m_s/js/lib/requirejs-text/text',
        jquery: 'gintonic_c_m_s/js/lib/jquery/jquery',
        bootstrap: 'gintonic_c_m_s/js/lib/bootstrap/bootstrap',
    },
    jsx: {
        fileExtension: '.jsx'
    },
    
    shim: {
        'bootstrap': [
            'jquery'
        ],
        'lib/admin-lte/app': [
            'jquery',
            'bootstrap'
        ],
        'lib/jvectormap/jquery-jvectormap-1.2.2.min': [
            'jquery'
        ],
        'lib/jvectormap/jquery-jvectormap-world-mill-en': [
            'jquery',
            'lib/jvectormap/jquery-jvectormap-1.2.2.min'
        ],
        'lib/slimScroll/jquery.slimscroll': [
            'jquery'
        ],
        'lib/admin-lte/pages/dashboard2': [
            'jquery',
            'bootstrap'
        ],
        'lib/admin-lte/demo': [
            'jquery',
            'bootstrap'
        ]
    }
});
