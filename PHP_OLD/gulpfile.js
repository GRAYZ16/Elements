var gulp = require('gulp'),
    jshint = require('gulp-jshint'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps');

sass.compiler = require('node-sass');

gulp.task('serve', ['sass', 'js'], function(){


  gulp.watch(['./_sass/**/*.scss'], ['sass']);
  //gulp.watch("js/*.js", ['js']);

});

/*gulp.task('js', function() {
  return gulp.src('./js/myscript.js')
    .pipe(jshint('./.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'));
});*/

gulp.task('sass', function () {
 return gulp.src('./sass/*.scss')
   .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
   .pipe(gulp.dest('./_css'));
});


gulp.task('default', ['serve', 'sass']);
