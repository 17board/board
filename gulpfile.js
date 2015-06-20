'use strict';

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    browserify = require('browserify'),
    watchify = require('watchify'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer'),
    babelify = require('babelify'),
    uglify = require('gulp-uglify'),
    _ = require('lodash');

var browserifyOpts = {extensions: ['.jsx']};

gulp.task('browserify', function() {
  browserify('./public/js/app.jsx', browserifyOpts)
    .transform(babelify)
    .bundle()
    .pipe(source('app.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(gulp.dest('./public/js'));
});

gulp.task('watchify', function() {
  var bundler = watchify(browserify('./public/js/app.jsx', _.extend({}, browserifyOpts, watchify.args)));

  function rebundle() {
    return bundler
      .bundle()
      .pipe(source('app.js'))
      .pipe(gulp.dest('./public/js'));
  }

  bundler.transform(babelify)
  .on('update', rebundle);
  return rebundle();
});

gulp.task('styles', function() {
  return gulp.src('./public/css/main.scss')
    .pipe(sass({errLogToConsole: true, outputStyle: 'compressed'}))
    .pipe(gulp.dest('./public/css'))
});

gulp.task('watchStyles', function() {
  gulp.watch('./public/css/**.scss', ['styles']);
});

gulp.task('watch', function() {
  gulp.start(['watchStyles', 'watchify', 'styles']);
});

gulp.task('build', function() {
  process.env.NODE_ENV = 'production';
  gulp.start(['browserify', 'styles']);
});

gulp.task('default', function() {
  gulp.start(['build']);
});