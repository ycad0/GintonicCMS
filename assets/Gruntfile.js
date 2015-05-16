module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    copy: {
        main: {
            files: [
                {
                    expand: true,
                    cwd: 'bower_components/admin-lte/build',
                    src: ['**'],
                    dest: 'src/less/lib/admin-lte/'
                },
                {
                    expand: true,
                    cwd: 'bower_components/admin-lte/dist/js',
                    src: ['**'],
                    dest: 'src/js/lib/admin-lte/'
                },
                {
                    expand: true,
                    cwd: 'bower_components/admin-lte/plugins',
                    src: ['**/?*.css'],
                    dest: 'src/css/lib/'
                },
                {
                    expand: true,
                    cwd: 'bower_components/admin-lte/plugins',
                    src: ['**/?*.js'],
                    dest: 'src/js/lib/'
                },
                {
                    expand: true,
                    cwd: 'bower_components/bootstrap/less',
                    src: ['**'],
                    dest: 'src/less/lib/bootstrap'
                },
                {
                    expand: true,
                    cwd: 'bower_components/bootstrap/dist/fonts',
                    src: ['**'],
                    dest: 'src/fonts/lib/bootstrap'
                },
                {
                    expand: true,
                    cwd: 'bower_components/bootstrap/js',
                    src: ['**'],
                    dest: 'src/js/lib/bootstrap'
                },
                {
                    expand: true,
                    cwd: 'bower_components/fontawesome/less',
                    src: ['**'],
                    dest: 'src/less/lib/fontawesome'
                },
                {
                    expand: true,
                    cwd: 'bower_components/fontawesome/fonts',
                    src: ['**'],
                    dest: 'src/fonts/lib/fontawesome'
                },
                {
                    expand: true,
                    cwd: 'bower_components/jquery/dist',
                    src: ['**'],
                    dest: 'src/js/lib/jquery'
                },
                {
                    expand: true,
                    cwd: 'bower_components/jsx-requirejs-plugin/js',
                    src: ['**'],
                    dest: 'src/js/lib/jsx-requirejs-plugin'
                },
                {
                    expand: true,
                    cwd: 'bower_components/',
                    src: ['react/*.js'],
                    dest: 'src/js/lib/'
                },
                {
                    expand: true,
                    cwd: 'bower_components',
                    src: ['requirejs-text/*.js'],
                    dest: 'src/js/lib/'
                }
            ]
        }
    },
    requirejs: {
        compile:{
            options: {
                appDir:"src/js",
                baseUrl:"./",
                dir:"../webroot/js",
                stubModules: ['jsx', 'text', 'JSXTransformer'],
                modules:[{
                    name: "config"
                }]
            }
        }
    }


    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-requirejs');
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Default task(s).
    grunt.registerTask('default', ['copy','requirejs']);

};
