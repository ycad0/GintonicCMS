requirejs.config({
    deps: [

    ],
    paths: {
        admin: "../vendor/admin-lte",
        "admin-lte": "../vendor/admin-lte/dist/js/app",
        autobahn: "../vendor/autobahn/autobahn",
        bootstrap: "../vendor/bootstrap/dist/js/bootstrap",
        "bootstrap-tagsinput": "../vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput",
        bootstrap_theme: "/bootstrap/app/",
        classnames: "../vendor/classnames/index",
        "eonasdan-bootstrap-datetimepicker": "../vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min",
        fontawesome: "../vendor/fontawesome/fonts/*",
        ionicons: "../vendor/ionicons/fonts/*",
        jquery: "../vendor/jquery/dist/jquery",
        "jsx-requirejs-plugin": "../vendor/jsx-requirejs-plugin/js/jsx",
        less: "../vendor/less/dist/less",
        moment: "../vendor/moment/moment",
        react: "../vendor/react/react",
        "requirejs-text": "../vendor/requirejs-text/text"
    },
    shim: {
        bootstrap: [
            "jquery"
        ],
        "eonasdan-bootstrap-datetimepicker": [
            "jquery",
            "bootstrap",
            "moment"
        ],
        "bootstrap-tagsinput": [
            "jquery",
            "bootstrap"
        ],
        "admin/dist/js/app": [
            "jquery"
        ],
        "admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min": [
            "jquery"
        ],
        "admin/plugins/jvectormap/jquery-jvectormap-world-mill-en": [
            "jquery",
            "vendor/jvectormap/jquery-jvectormap-1.2.2.min"
        ],
        "admin/plugins/slimScroll/jquery.slimscroll": [
            "jquery"
        ],
        "admin/dist/js/pages/dashboard2": [
            "jquery",
            "bootstrap"
        ],
        "admin/dist/js/demo": [
            "jquery",
            "bootstrap"
        ]
    },
    jsx: {
        fileExtension: ".jsx"
    },
    packages: [

    ]
});
