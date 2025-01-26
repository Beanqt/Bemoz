var config = {
    url: "bemoz.local",
    node_modules: '../../node_modules/',
    assets: 'resources/assets/'
};

var paths = {
    sass: [
        config.assets+'sass/public/app.scss'
    ],
    js: [
        config.assets+'js/vendor/jquery/jquery-3.6.0.js',
        config.assets+'js/vendor/moment/moment.min.js',
        config.assets+'js/vendor/moment/hu.js',
        config.assets+'js/vendor/bootstrap/bootstrap.js',
        config.assets+'js/vendor/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.js',
        config.assets+'js/vendor/slick-carousel/slick.min.js',
        config.assets+'js/vendor/validator/validator.js',

        config.assets+'js/public/_functions.js',
        config.assets+'js/public/Plugins/*.js',
        config.assets+'js/public/Views/*.js',
        config.assets+'js/public/Kernel/*.js',

        config.assets+'js/public/_routes.js',
        config.assets+'js/public/app.js',
    ],
    adminSass: [
        config.assets+'sass/throne/throne.scss'
    ],
    adminJs: [
        config.assets+'js/vendor/jquery/jquery-3.6.0.js',
        config.assets+'js/vendor/jquery-ui/jquery-ui.min.js',
        config.assets+'js/vendor/moment/moment.min.js',
        config.assets+'js/vendor/moment/hu.js',
        config.assets+'js/vendor/bootstrap/bootstrap.js',
        config.assets+'js/vendor/mjolnic-bootstrap-colorpicker/bootstrap-colorpicker.min.js',
        config.assets+'js/vendor/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.js',
        config.assets+'js/vendor/chart/Chart.js',
        config.assets+'js/vendor/validator/validator.js',
        config.assets+'js/vendor/slim/slim.jquery.js',
        config.assets+'js/vendor/nestable/nestable.js',
        config.assets+'js/vendor/dropzone/dropzone.js',

        config.assets+'js/throne/kernel/functions.js',
        config.assets+'js/throne/kernel/routes.js',
        config.assets+'js/throne/kernel/notifyManager.js',
        config.assets+'js/throne/kernel/modalManager.js',
        config.assets+'js/throne/kernel/help.js',
        config.assets+'js/throne/kernel/pageManager.js',
        config.assets+'js/throne/throne.js',

        config.assets+'js/throne/plugins/mediaManager.js',
        config.assets+'js/throne/plugins/autocomplete.js',
        config.assets+'js/throne/plugins/characterLength.js',
        config.assets+'js/throne/plugins/dynamicElements.js',
        config.assets+'js/throne/plugins/widgetCreator.js',
        config.assets+'js/throne/plugins/fileBox.js',
        config.assets+'js/throne/plugins/selector.js'
    ]
};

const gulp             = require(config.node_modules+'gulp');
const autoprefixer     = require(config.node_modules+'gulp-autoprefixer');
const sass       	   = require(config.node_modules+'gulp-sass')(require('sass'));
const uglify     	   = require(config.node_modules+'gulp-uglify');
const concat           = require(config.node_modules+'gulp-concat');
const clean            = require(config.node_modules+'gulp-clean-css');
const browserSync      = require(config.node_modules+'browser-sync').create();
const fontIcon         = require(config.node_modules+'gulp-font-icon');
var exec               = require(config.node_modules+'gulp-exec');
var test               = false;

exec = require('child_process').exec;

gulp.task('start', function(){
    test = true;
    browserSync.init({
        proxy: {
            target: 'https://'+config.url,
            proxyReq: [
                function(proxyReq) {
                    proxyReq.setHeader('browsersync-header', 'true');
                }
            ]
        },
        host: config.url,
        open: 'external',
        ghostMode: false,
        files: [
            'resources/views/**/*.php',
        ],
        snippetOptions: {
            rule: {
                match: /(<\/body>|<\/pre>)/i,
                fn: function (snippet, match) {
                    return snippet + match;
                }
            }
        }
    });
    gulp.watch(['resources/assets/sass/public/*.scss','resources/assets/sass/public/**/*.scss'], gulp.series(['public:sass']));
    gulp.watch(['resources/assets/sass/throne/*.scss','resources/assets/sass/throne/**/*.scss'], gulp.series(['admin:sass']));
    gulp.watch(['resources/assets/js/public/Controllers/*.js'], gulp.series(['public:js']));
    gulp.watch(paths.js, gulp.series(['public:js']));
    gulp.watch(paths.adminJs, gulp.series(['admin:js']));
});

gulp.task('public:sass', function(){
    return compressSass(gulp.src(paths.sass), 'public/assets/stylesheets');
});

gulp.task('admin:sass', function(){
    return compressSass(gulp.src(paths.adminSass), 'public/assets/stylesheets/throne');
});

gulp.task('public:js', function(){
    compressJs(gulp.src(config.assets+'js/public/Controllers/*.js')).pipe(gulp.dest('public/assets/scripts/controllers'));

    return compressJs(gulp.src(paths.js).pipe(concat('app.js'))).pipe(gulp.dest('public/assets/scripts')).pipe(browserSync.stream())
});

gulp.task('admin:js', function(){
    return compressJs(gulp.src(paths.adminJs).pipe(concat('app.js'))).pipe(gulp.dest('public/assets/scripts/throne')).pipe(browserSync.stream());
});

gulp.task('icon-convert', function(){
    return gulp.src(['public/images/icons/*.svg'])
        .pipe(fontIcon({
            fontName: "Hinora",
            fontAlias: "icon",
            normalize: true,
            fontHeight: 1001
        }))
        .pipe(gulp.dest("public/assets/fonts/HinoraIcons/"));
});

gulp.task('install', gulp.series('public:sass', 'admin:sass', 'public:js', 'admin:js'));

function compressJs(task){
    return !test ? task.pipe(uglify()) : task;
}

function compressSass(task, dest){
    task = task.pipe(concat('app.css')).pipe(autoprefixer({overrideBrowserslist: ['last 2 versions']})).pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError));
    task = !test ? task.pipe(clean({level: {1: {all: true, roundingPrecision: false, specialComments: 0}, 2: {all: true, removeUnusedAtRules: false, mergeSemantically: false}}})) : task;

    return task.pipe(gulp.dest(dest)).pipe(browserSync.stream());
}