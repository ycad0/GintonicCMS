requirejs.config({
    deps: [

    ],
    paths: {
        "jsx-requirejs-plugin": "../vendor/jsx-requirejs-plugin/js/jsx",
        react: "../vendor/react/react",
        "requirejs-text": "../vendor/requirejs-text/text",
        less: "../vendor/less/dist/less",
        bootstrap: "../vendor/bootstrap/dist/js/bootstrap",
        jquery: "../vendor/jquery/dist/jquery",
        autobahn: "../vendor/autobahn/autobahn",
        classnames: "../vendor/classnames/index",
        "eonasdan-bootstrap-datetimepicker": "../vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min",
        moment: "../vendor/moment/moment"
    },
    shim: {
        bootstrap: [
            "jquery"
        ],
        "eonasdan-bootstrap-datetimepicker": [
            "jquery",
            "bootstrap",
            "moment"
        ]
    },
    jsx: {
        fileExtension: ".jsx"
    },
    packages: [

    ]
});
