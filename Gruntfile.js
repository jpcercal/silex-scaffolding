module.exports = function (grunt) {
    'use strict';

    require('time-grunt')(grunt);

    var env = require('node-env-file');
    env('./.env');

    var debug  = process.env.APP_DEBUG.toLowerCase() === 'true' ? true : false;
    var config = grunt.file.readJSON('config.json');

    grunt.initConfig({

        config:          config,
        pkg:             grunt.file.readJSON(config.filename.package),
        license:         grunt.file.read(config.filename.license),

        banner:          "/*\n<%= license %>*/\n",

        dist_js_path:    "<%= config.path.dist %>/<%= config.path.src.js %>",
        dist_css_path:   "<%= config.path.dist %>/<%= config.path.src.css %>",
        dist_font_path:  "<%= config.path.dist %>/<%= config.path.src.font %>",
        dist_img_path:   "<%= config.path.dist %>/<%= config.path.src.img %>",
        dist_tpl_path:   "<%= config.path.dist %>/<%= config.path.src.tpl %>",

        src_app_path:    "<%= config.path.src.base %>/<%= config.path.src.app %>",
        src_less_path:   "<%= config.path.src.base %>/<%= config.path.src.less %>",

        jshint: {
            files: [
                'Gruntfile.js',
                '<%= config.path.src.base %>/<%= config.path.src.js %>/**/*.js',
                '<%= config.path.src.base %>/<%= config.path.src.app %>/**/*.js'
            ],
            options: {
                globals: {
                    console: true
                }
            }
        },

        clean: {
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '.tmp',
                        '<%= config.path.dist %>/'
                    ]
                }]
            }
        },

        concat: {
            options: {
                stripBanners: true,
                banner: '<%= banner %>'
            },
            dist: {
                src: config.concat.files,
                dest: '<%= dist_js_path %>/<%= config.package.name %>.js'
            }
        },

        copy: {
            dist: {
                files: [
                    {
                        expand: true,
                        cwd: '<%= config.path.src.base %>/<%= config.path.src.img %>/',
                        src: ['**/*'],
                        dest: '<%= dist_img_path %>/'
                    },
                    {
                        expand: true,
                        cwd: '<%= src_app_path %>/modules/',
                        src: ['**/partials/**/*'],
                        dest: '<%= dist_tpl_path %>/'
                    }
                ]
            }
        },

        less: {
            dist: {
                options: {
                    banner: '<%= banner %>'
                },
                files: {
                    '<%= dist_css_path %>/<%= config.package.name %>.css': '<%= src_less_path %>/<%= config.package.name %>.less'
                }
            }
        },

        htmlmin: {
            dist: {
                options: {
                    removeComments: true,
                    collapseWhitespace: true
                },
                files: [
                    {
                        expand: true,
                        cwd: '<%= dist_tpl_path %>/',
                        src: ['**/*.tpl.html'],
                        dest: '<%= dist_tpl_path %>/'
                    }
                ]
            }
        },

        cssmin: {
            dist: {
                files: {
                    '<%= dist_css_path %>/<%= config.package.name %>.min.css': [
                        '<%= dist_css_path %>/<%= config.package.name %>.css',
                    ]
                }
            }
        },

        uglify: {
            dist: {
                files: {
                    '<%= dist_js_path %>/<%= config.package.name %>.min.js': [
                        '<%= concat.dist.dest %>'
                    ]
                }
            }
        },

        imagemin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= dist_img_path %>/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '<%= dist_img_path %>/'
                }]
            }
        },

        'gh-pages': {
            options: {
                base: '<%= config.path.dist %>'
            },
            src: ['**']
        },

        notify_hooks: {
            options: {
                enabled: true,
                max_jshint_notifications: 5,
                title: "<%= config.package.name %>",
                success: true,
                duration: 2
            }
        },

        connect: {
            options: {
                port: 9000,
                livereload: 35729,
                hostname: 'localhost'
            },
            livereload: {
                options: {
                    open: true,
                    base: '<%= config.path.dist %>',
                    livereload: true,
                    keepalive: true
                }
            },
            dist: {
                options: {
                    open: true,
                    base: '<%= config.path.dist %>',
                    livereload: false,
                    keepalive: true
                }
            }
        },

        watch: {
            options: {
                livereload: '<%= connect.options.livereload %>'
            },
            files: ['<%= config.path.src.base %>/**/*'],
            tasks: ['default']
        }
    });

    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-gh-pages');
    grunt.loadNpmTasks('grunt-notify');
    grunt.loadNpmTasks('grunt-contrib-connect');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('debug_on', [
        'jshint',
        'clean',
        'concat',
        'copy',
        'less',
    ]);

    grunt.registerTask('debug_off', [
        'debug_on',
        'htmlmin',
        'cssmin',
        'uglify',
        'imagemin'
    ]);

    grunt.registerTask('default', [
        debug === true ? 'debug_on' : 'debug_off',
        'notify_hooks'
    ]);

    grunt.registerTask('publish', [
        'debug_off',
        'gh-pages',
        'notify_hooks'
    ]);
};
