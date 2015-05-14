module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    bower: {
      install: {
        options: {
          targetDir: './src',
          layout: 'byType',
          install: true,
          verbose: false,
          cleanTargetDir: false,
          cleanBowerDir: false,
          bowerOptions: {}
        }
      }
    },
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        files: grunt.file.expandMapping(['src/optimized/**/*.js', 'src/optimized*.js'], '../webroot/', {
            rename: function(destBase, destPath) {
                console.log(destBase);
                console.log(destPath);
                return destBase+destPath.replace('src/optimized', '').replace();
            }
        })
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
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-requirejs');
  grunt.loadNpmTasks('grunt-bower-task');

  // Default task(s).
  grunt.registerTask('default', ['requirejs']);

};
