var gulp = require('gulp');
var concat = require('gulp-concat');
var sass = require('gulp-sass');
var del = require('del');

var path = {
    sass: 'resources/assets/sass/*.scss'
};
var components = [
    'jquery/dist/jquery.min.js',
    'Materialize/bin/materialize.js',
    'vue/dist/vue.min.js',
    'marked/marked.min.js'
];

gulp.task('components', function() {
    del(['public/builds/js/components.js']);
    var sources = [];
    for (var i in components) {
        sources.push('bower_components/' + components[i]);
    }
    return gulp.src(sources)
        .pipe(concat('components.js'))
        .pipe(gulp.dest('public/builds/js'));
});

gulp.task('sass', function() {
    gulp.src(path.sass)
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/builds/css'));
});

gulp.task('fonts', function() {
    var sources = [];
    sources.push('bower_components/Materialize/dist/font/**');
    gulp.src(sources)
        .pipe(gulp.dest('public/builds/font'));
});

gulp.task('watch', function() {
    gulp.watch(path.sass, ['sass']);
});

gulp.task('default', ['watch', 'components', 'sass', 'fonts']);
