/* jshint node: true */

module.exports = function(grunt) {
    "use strict";

    // Project configuration.
    grunt.initConfig({

        // Metadata.
        pkg: grunt.file.readJSON('package.json'),
        banner: '/**\n' +
            '* <%= pkg.name %>.js v<%= pkg.version %> by @fat and @mdo\n' +
            '* Copyright <%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
            '* <%= _.pluck(pkg.licenses, "url").join(", ") %>\n' +
            '*/\n',
        jqueryCheck: 'if (!jQuery) { throw new Error(\"Embed Google Maps requires jQuery\") }\n\n',

        // Task configuration.
        clean: {
            dist: ['dist']
        },

        jshint: {
            options: {
                jshintrc: 'js/.jshintrc'
            },
            gruntfile: {
                src: 'Gruntfile.js'
            },
            src: {
                src: ['assets/js/*.js']
            }
        },

        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            egm: {
                files: {
                    'assets/dist/js/egm-client.min.js': ['assets/js/egm-client.js'],
                    'assets/dist/js/egm-admin.min.js': ['assets/js/egm-admin.js']
                }
            }
        },

        compass: {
            dist: {
                options: {
                    sassDir: 'assets/scss',
                    cssDir: 'assets/css',
                    environment: 'development'
                }
            }
        },

        watch: {
            scripts: {
                files: 'assets/js/*.js',
                tasks: ['uglify']
            },
            compass: {
                files: 'assets/scss/*.scss',
                tasks: ['compass']
            }
        }
    });


    // These plugins provide necessary tasks.
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-compass');

    // default task.
    grunt.registerTask('default', ['uglify', 'compass']);
};